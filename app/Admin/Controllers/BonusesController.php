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
        $grid->column('type', __('Type'));
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

        $grid->field('id', __('Id'));
        $grid->field('user_id', __('User Id'));
        $grid->field('order_id', __('Order id'));
        $grid->field('type', __('Type'));
        $grid->field('bonus', __('Bonus'));
        $grid->field('created_at', __('Created at'));
        $grid->field('updated_at', __('Updated at'));


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

        $grid->number('user_id', __('User Id'));
        $grid->number('order_id', __('Order id'));
        $grid->number('type', __('Type'));
        $grid->decimal('bonus', __('Bonus'));

        return $form;
    }
}
