<?php

namespace App\Admin\Controllers\wx;

use App\Models\Ad;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AdController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '广告管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Ad());

        $grid->column('id', __('ID'));
        $grid->column('image', __('广告图'))->image();
        $grid->column('position', __('广告位编号'));
        $grid->column('created_at', __('创建时间'));

        $grid->disableExport();
        $grid->disableFilter();
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
        $show = new Show(Ad::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('image', '广告图')->image();
        $show->field('position', '广告位编号');
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '更新时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Ad());

        $form->image('image', '广告图')->required('请选择图片');
        $form->text('position', '广告位编号');

        return $form;
    }
}
