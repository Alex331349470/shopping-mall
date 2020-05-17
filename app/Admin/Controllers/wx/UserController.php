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
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;
use mysql_xdevapi\ColumnResult;
use phpDocumentor\Reflection\Type;
use function foo\func;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '会员管理';

    protected $description = [
        'show' => '推广用户',
    ];

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());
        $grid->header(function ($query) {
            $gender = $query->select(DB::raw('count(a.gender) as count, a.gender'))
                ->groupBy('a.gender')->get()->pluck('count', 'gender')->toArray();
            $doughnut = view('gender', compact('gender'));

            return new Box('性别比例', $doughnut);
        });
        $grid->footer(function ($query) {
            $user_type = $query->select(DB::raw('count(a.type) as count, a.type'))->groupBy('a.type')->get()->pluck('count', 'type')->toArray();
            $doughnut = view('user_type', compact('user_type'));

            return new Box('类型比例', $doughnut);
        });
        $grid->model()->join(DB::raw("user_infos a"), "a.user_id", "=", "users.id")->join(DB::raw("users b"), "a.parent_id", "=", "b.id", "left")->selectRaw("users.id,users.name,users.phone,users.avatar,a.sub,a.gender,a.type,b.name as name2,users.created_at");

        $grid->column('id', __('Id'));
        $grid->column('name', __('微信昵称'));
        $grid->column('phone', __('手机号'));
        $grid->column('avatar', __('微信头像'))->image("头像");
        $grid->column('sub',__('是否订阅'))->display(function ($value) {
            return $value == 1?"已订阅":"";
        });
        $grid->column('gender', __('性别'))->display(function($value) {
            $gender_arr = config('admin.gender');
            return isset($gender_arr[$value])?$gender_arr[$value]:dd($value) . '未知';
        });
        $grid->column('type', __('用户类型'))->display(function($value) {
            $user_type = config('admin.user_type');
            return isset($user_type[$value])?$user_type[$value]:'未知';
        });
        $grid->column("name2", __("上级名称"));

        $grid->column('created_at', __('创建时间'));

        $grid->disableExport();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            if ($actions->row->type == 0) {
                $actions->disableView();
            }
        });
        $grid->filter(function (Grid\Filter $filter) {
            $filter->disableIdFilter();
            $filter->like('name', '微信昵称');
            $filter->equal('phone', '手机号');
        });
        return $grid;
    }

    public function show($id, Content $content)
    {
        $user = User::query()->findOrFail($id);
        return $content
            ->title($user->name)
            ->description($this->description['show'] ?? trans('admin.show'))
            ->body($this->detail2($id));
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail2($id)
    {
        $user = UserInfo::query()->where("user_id", $id)->firstOrFail();
        $user_info = new UserInfo();
        // 所有父级id
        $id_arr = $user_info->getAllChildrenIdById($id, $user->type==2?true:false);
        $grid = new Grid(new User());
        $grid->model()->join('user_infos', 'users.id', '=', 'user_id')
            ->whereIn('parent_id', $id_arr)
            ->selectRaw('users.id,name,phone,avatar,sub,gender,type,users.created_at');

        $grid->column('id', __('Id'));
        $grid->column('name', __('微信昵称'));
        $grid->column('phone', __('手机号'));
        $grid->column('avatar', __('微信头像'))->image("头像");
        $grid->column('sub',__('是否订阅'))->display(function ($value) {
            return $value == 1?"已订阅":"";
        });
        $grid->column('gender', __('性别'))->display(function($value) {
            $gender_arr = config('admin.gender');
            return isset($gender_arr[$value])?$gender_arr[$value]:dd($value) . '未知';
        });
        $grid->column('type', __('用户类型'))->display(function($value) {
            $user_type = config('admin.user_type');
            return isset($user_type[$value])?$user_type[$value]:'未知';
        });

        $grid->column('created_at', __('创建时间'));

        $grid->disableExport();
        $grid->disableCreateButton();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            if ($actions->row->type == 0) {
                $actions->disableView();
            }
        });
        $grid->filter(function (Grid\Filter $filter) {
            $filter->disableIdFilter();
            $filter->like('name', '微信昵称');
            $filter->equal('phone', '手机号');
        });
        return $grid;
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
