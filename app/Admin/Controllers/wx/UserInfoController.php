<?php

namespace App\Admin\Controllers\wx;

use App\Models\UserInfo;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Illuminate\Support\Facades\DB;

class UserInfoController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '等级设置';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserInfo());

        $grid->header(function ($query) {

            $gender = $query->select(DB::raw('count(gender) as count, gender'))
                ->groupBy('gender')->get()->pluck('count', 'gender')->toArray();
            $doughnut = view('gender', compact('gender')) ;

            return new Box('性别比例', $doughnut);
        });
        $grid->footer(function ($query) {
            $user_type = $query->select(DB::raw('count(type) as count, type'))->groupBy('type')->get()->pluck('count', 'type')->toArray();
            $doughnut = view('user_type', compact('user_type'));

            return new Box('类型比例', $doughnut);
        });

        $grid->column('id', __('ID'));
        $grid->column('user.name', __('微信昵称'));
        $grid->column('user.phone', __('手机号'));
        // 账号类别：0-普通用户,1-二级代理,2-一级代理
        $grid->column('type', __('代理等级'))->display(function ($type) {
            switch ($type) {
                case '1':
                    return '二级代理';
                case '2':
                    return '一级代理';
                default:
                    return '普通用户';
            }
        });
        // 性别:0-保密,1-男,2-女
        $grid->column('gender', __('性别'))->display(function ($sex) {
            switch ($sex) {
                case '1':
                    return '男';
                case '2':
                    return '女';
                default:
                    return '保密';
            }
        });

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
        });
        $grid->disableExport();
        $grid->filter(function (Grid\Filter $filter) {
            $filter->disableIdFilter();
            $filter->like('name', '微信昵称');
            $filter->equal('phone', '手机号');
        });
        $grid->disableCreateButton();
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
        $user_info = UserInfo::query()->select([
            'user_infos.id',
            'users.name',
            'users.phone',
            'type',
            'gender',
            'user_infos.created_at'
        ])->join('users', 'user_id', '=', 'users.id', 'right')->findOrFail($id);
        $show = new Show($user_info);

        $show->field('id', __('ID'));
        $show->field('name', __('微信昵称'));
        $show->field('phone', __('手机号'));
        $show->field('new_type', __('账号类别'));
        $show->field('new_gender', __('性别'));
        $show->field('created_at', __('创建时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UserInfo());

        $form->display('user.name', __('微信昵称'))->disable();
        $form->display('user.phone', __('手机号'))->disable();
        // 账号类别：0-普通用户,1-二级代理,2-一级代理
        $form->radio('type', __('账号类别'))->options(config('admin.user_type'));
        // 性别:0-保密,1-男,2-女
        $form->radio('gender', __('性别'))->options(config('admin.gender'));

        $form->disableCreatingCheck();
        $form->disableEditingCheck();
        $form->disableViewCheck();
        return $form;
    }
}
