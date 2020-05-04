<?php

namespace App\Admin\Controllers;

use App\Models\Bonus;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BonusesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\Bonus';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Bonus);

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User Id'));
        $grid->column('order_id', __('Order id'));
        $grid->column('user_type', __('Type'));
        $grid->column('bonus', __('Bonus'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));


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
        $show = new Show(Bonus::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User Id'));
        $show->field('order_id', __('Order id'));
        $show->field('user_type', __('Type'));
        $show->field('bonus', __('Bonus'));
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
        $form = new Form(new Bonus);

        $form->number('user_id', __('User Id'));
        $form->number('order_id', __('Order id'));
        $form->number('user_type', __('Type'));
        $form->decimal('bonus', __('Bonus'));

        return $form;
    }
}
