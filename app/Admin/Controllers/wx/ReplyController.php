<?php

namespace App\Admin\Controllers\wx;

use App\Models\Reply;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ReplyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '评论管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Reply());

        $grid->column('id', __('ID'));
        $grid->column('goods.title', __('商品名'));
        $grid->column('user.name', __('微信昵称'));
        $grid->column('order_id', __('订单ID'));
        $grid->column('images', __('评论图集'))->display(function ($pictures) {
            return json_decode($pictures, true);
        })->image('', 100, 100);
        $grid->column('content', __('评论内容'));
        $grid->column('passed', __('是否显示'))->display(function($value) {
            return $value?'是':'否';
        });
        $grid->column('created_at', __('评论时间'));

        $grid->tools(function (Grid\Tools $tools) {
            $tools->disableBatchActions();
        });

        $grid->actions(function (Grid\Displayers\Actions $action) {
            $action->disableView();
        });
        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->filter(function (Grid\Filter $filter) {
            $filter->disableIdFilter();
            $filter->like('goods.title', '商品名');
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
        $show = new Show(Reply::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('good_id', __('Good id'));
        $show->field('user_id', __('User id'));
        $show->field('order_id', __('Order id'));
        $show->field('images', __('Images'));
        $show->field('content', __('Content'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Reply());

        $form->number('goods.title', __('商品名称'))->disable();
        $form->number('user.name', __('微信昵称'))->disable();
        $form->number('order_id', __('订单id'))->disable();
        $form->text('images', __('评论图集地址'))->disable();
        $form->textarea('content', __('Content'))->disable();
        $form->switch('passed', __('是否通过'));
        return $form;
    }
}
