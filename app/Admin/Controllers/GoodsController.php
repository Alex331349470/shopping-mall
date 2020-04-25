<?php

namespace App\Admin\Controllers;

use App\Models\Good;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GoodsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Good);

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('description', __('Description'));
        $grid->column('on_hot', __('On hot'));
        $grid->column('on_sale', __('On sale'));
        $grid->column('content', __('Content'));
        $grid->column('express_price', __('Express price'));
        $grid->column('price', __('Price'));
        $grid->column('rating', __('Rating'));
        $grid->column('category_id', __('Category id'));
        $grid->column('good_no', __('Good no'));
        $grid->column('stock', __('Stock'));
        $grid->column('sold_count', __('Sold count'));
        $grid->column('review_count', __('Review count'));
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
        $show = new Show(Good::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('description', __('Description'));
        $show->field('on_hot', __('On hot'));
        $show->field('on_sale', __('On sale'));
        $show->field('content', __('Content'));
        $show->field('express_price', __('Express price'));
        $show->field('price', __('Price'));
        $show->field('rating', __('Rating'));
        $show->field('category_id', __('Category id'));
        $show->field('good_no', __('Good no'));
        $show->field('stock', __('Stock'));
        $show->field('sold_count', __('Sold count'));
        $show->field('review_count', __('Review count'));
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
        $form = new Form(new Good);

        $form->text('title', __('Title'));
        $form->text('description', __('Description'));
        $form->switch('on_hot', __('On hot'))->default(1);
        $form->switch('on_sale', __('On sale'))->default(1);
        $form->textarea('content', __('Content'));
        $form->decimal('express_price', __('Express price'))->default(0.00);
        $form->decimal('price', __('Price'))->default(0.00);
        $form->decimal('rating', __('Rating'))->default(5.00);
        $form->number('category_id', __('Category id'));
        $form->hasMany('images', '图片列表', function (Form\NestedForm $form) {
            $form->text('description', '图片描述');
            $form->image('image', '产品图片')->rules('image');
        });
        $form->text('good_no', __('Good no'));
        $form->number('stock', __('Stock'));
        $form->number('sold_count', __('Sold count'));
        $form->number('review_count', __('Review count'));

        return $form;
    }
}
