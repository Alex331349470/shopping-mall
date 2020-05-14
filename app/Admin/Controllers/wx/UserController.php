<?php

namespace App\Admin\Controllers\wx;

use App\Models\User;
use App\Models\UserInfo;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use function foo\func;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '会员管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());
        $grid->header(function ($query) {
            $gender = $query->join('user_infos', 'users.id', '=', 'user_id', 'left')->select(DB::raw('count(user_infos.gender) as count, user_infos.gender'))
                ->groupBy('user_infos.gender')->get()->pluck('count', 'gender')->toArray();
            $doughnut = view('gender', compact('gender'));

            return new Box('性别比例', $doughnut);
        });
        $grid->footer(function ($query) {
            $user_type = $query->join('user_infos', 'users.id', '=', 'user_id', 'left')->select(DB::raw('count(user_infos.type) as count, user_infos.type'))->groupBy('user_infos.type')->get()->pluck('count', 'type')->toArray();
            $doughnut = view('user_type', compact('user_type'));

            return new Box('类型比例', $doughnut);
        });

        $grid->column('id', __('Id'));
        $grid->column('name', __('微信昵称'));
        $grid->column('phone', __('手机号'));
        $grid->column('avatar', __('微信头像'));
        $grid->column('info.sub',__('是否订阅'));
        $grid->column('info.gender', __('性别'))->display(function($value) {
            $gender_arr = config('admin.gender');
            return isset($gender_arr[$value])?$gender_arr[$value]:dd($value) . '未知';
        });
        $grid->column('info.type', __('用户类型'))->display(function($value) {
            $user_type = config('admin.user_type');
            return isset($user_type[$value])?$user_type[$value]:'未知';
        });

        $grid->column('created_at', __('创建时间'));

        $grid->disableExport();
        $grid->filter(function (Grid\Filter $filter) {
            $filter->disableIdFilter();
            $filter->like('name', '微信昵称');
            $filter->equal('phone', '手机号');
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('微信昵称'));
        $show->field('phone', __('手机号'));
        $show->field('avatar', __('微信头像'));
        $show->field('open_id',__('open id'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $id = request()->route('user');
        if ($id) {
            $unique_rule = Rule::unique('users')->ignore($id);
        } else {
            $unique_rule = 'unique:users';
        }
        $form->text('name', __('微信昵称'))->rules(['required', 'max:40'], [
            'required' => '昵称未填写',
            'max' => '昵称长度最大为40'
        ]);
        $form->mobile('phone', __('手机号'))->rules(['required', $unique_rule], [
            'required' => '手机号未填写',
            'unique' => '手机号已存在',
        ]);

        $form->switch('info.sub',__('订阅'))->default(false);
        // 账号类别：0-普通用户,1-二级代理,2-一级代理
        $form->select('info.type', __('账号类别'))->options(config('admin.user_type'));
        // 性别:0-保密,1-男,2-女
        $form->select('info.gender', __('性别'))->options(config('admin.gender'));
        $form->image('avatar', __('微信头像'));
        $form->password('password', __('密码 '));


        return $form;
    }

}
