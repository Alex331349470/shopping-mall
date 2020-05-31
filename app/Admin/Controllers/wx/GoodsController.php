<?php

namespace App\Admin\Controllers\wx;

use App\Admin\Extensions\ModelDelete;
use App\Admin\Extensions\ModelList;
use App\Models\Category;
use App\Models\Good;
use App\Models\GoodImage;
use App\Models\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;

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
        $grid = new Grid(new Good());
        $type = request()->get("type");
        switch ($type) {
            case 2: // 100 - 200庫存
                $grid->model()->whereBetween('stock', [100, 200]);
                break;
            case 3: // 50 - 100 库存
                $grid->model()->whereBetween('stock', [50, 99]);
                break;
            case 4: // 0 - 50 库存
                $grid->model()->whereBetween('stock', [0, 49]);
                break;
            default:
        }
        $grid->header(function($query) {
            $info['total_hundred'] = Good::getHundredWhere()->count();
            $info['total_fifty'] = Good::getFiftyWhere()->count();
            $info['total_zero'] = Good::getZeroWhere()->count();
            $info['total_all'] = Good::query()->count();
            $doughnut = view('admin.goods.header', compact('info'));
            return new Box('商品库存展示', $doughnut);
        });

        $grid->column('id', __('Id'));
        $grid->column('title', __('名称'));
        $grid->column('description', __('描述'));
        $grid->column('on_hot', __('是否推荐'))->display(function ($value) {
            if ($value == 1) {
                return '是';
            } else {
                return '否';
            }
        });
        $grid->column('on_sale', __('是否上架'))->display(function ($value) {
            if ($value == 1) {
                return '是';
            } else {
                return '否';
            }
        });
        $grid->column('express_price', __('市场价'));
        $grid->column('price', __('售价'));
        $grid->column('rating', __('评分'));
        $grid->column('category.name', __('分类名称'));
        $grid->column('weight',__('重量(KG)'));
        $grid->column('good_no', __('商品货号'));
        $grid->column('brand', __('品牌'));
        $grid->column('stock', __('库存'));
        $grid->column('sold_count', __('销量'));
        $grid->column('review_count', __('浏览量'));
        $grid->column('created_at', __('创建时间'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
//            $actions->add(new ModelList($actions->getKey(), 'images.index', '图片列表'));
        });

        $grid->disableExport();
        $grid->filter(function (Grid\Filter $filter) {
            $filter->disableIdFilter();
            $filter->like('title', '名称');
            $filter->like('category.name', '分类名称');
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
        $show = new Show(Good::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('description', __('Description'));
        $show->field('on_hot', __('On hot'));
        $show->field('on_sale', __('On sale'));
        $show->field('content', __('Content'));
        $show->field('express_price', __('Express price'));
        $show->field('price', __('Price'));
        $show->field('weight',__('Weight'));
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
        $form = new Form(new Good());

        $id = request()->route('good');
        if ($id) {
            $unique_rule = Rule::unique('goods')->ignore($id);
        } else {
            $unique_rule = 'unique:goods';
        }
        $form->text('title', __('名称'))->rules(['required', $unique_rule, 'max:255'], ['required' => '名称必填', 'unique' => '名称已存在', 'max' => '名称最大长度为255']);
        $form->text('description', __('描述'));
        $form->switch('on_hot', __('是否推荐'))->default(1);
        $form->switch('on_sale', __('是否上架'))->default(1);
        $form->UEditor('content', __('详情'))->required()->help("产品展示的图文详情页面");
        $rules = ['min:0'];
        $form->decimal('express_price', __('市场价'))->attribute('min', '0.0')->default(0.00)->rules($rules);
        $form->decimal('price', __('售价'))->attribute('min', '0.0')->default(0.00)->help('建议售价比市场价低')->required()->rules($rules);
        $form->decimal('weight',__('重量(KG)'))->default(0.00);
        $form->decimal('rating', __('评分'))->attribute('min', '0.0')->default(5.00)->rules($rules);

        $category_lv1 = Category::query()->get(['id', 'name'])->pluck('name', 'id');
        $form->select('category_id', __('分类名称'))->options($category_lv1)->required();

        $form->text('good_no', __('商品货号'));
        $form->text('brand', __('品牌'));
        $form->number('stock', __('库存'))->attribute('min', '0')->required()->rules($rules);
        $form->hasMany('images', '商品图集',function (Form\NestedForm $form) {
            $form->text('description', '图片描述');
            $form->image('image', '产品图片')->rules('image');
            $form->switch('cover', '是否为封面图')->default(0);
        });
        // 直接添加一对多的关联模型
        $form->hasMany('skus', 'SKU 列表', function (Form\NestedForm $form) {
            $form->text('title', 'SKU 名称');
            $form->text('description', 'SKU 描述');
            $form->text('price', '单价')->rules('numeric|min:0.01');
            $form->text('stock', '剩余库存')->rules('integer|min:0');
        });

        // 定义事件回调，当模型即将保存时会触发这个回调
        $form->saving(function (Form $form) {
            $form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price') ?: 0;
        });
        $form->disableCreatingCheck();
        $form->disableEditingCheck();
        $form->disableViewCheck();
        return $form;
    }

    public function imageList(Content $content, Good $goods) {
//        dd($goods);
        return $content->title($goods->title . ' 商品图集')
            ->description($this->description['index'] ?? trans('admin.list'))
            ->body($this->imgGrid());
    }

    protected function imgGrid() {
        $grid = new Grid(new GoodImage());

        $grid->column('id', 'Id');
        $grid->column('goods.title', '商品名称');
        $grid->column('image', '展示图')->image();
        $grid->column('description', '图片描述');
        $grid->column('cover', '是否为商品封面')->display(function ($value) {
            if ($value == 1) {
                return '是';
            } else {
                return '否';
            }
        });
        $grid->column('created_at', '创建时间');

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            $actions->add(new ModelDelete($actions->getKey(), 'images'));
        });
        $grid->disableExport();
        $grid->disableFilter();
        return $grid;
    }

    public function createImg(Content $content) {
        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($this->formImg());
    }

    public function editImg($image, Content $content) {
        $id = request()->route('image');
        return $content
            ->title($this->title())
            ->description($this->description['edit'] ?? trans('admin.edit'))
            ->body($this->formImg()->edit($id));
    }

    protected function formImg() {
        $form = new Form(new GoodImage());

        $rules = ['required'];
        $form->hidden('good_id')->default(request()->route('goods'));
        $form->image('image', '展示图')->removable()->rules($rules);
        $form->text('description', '描述');
        $form->switch('cover', '是否为封面图')->default(0);

        $form->disableViewCheck();
        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        return $form;
    }

    public function updateImg()
    {
        $data = request()->all(['good_id', 'cover']);
        $id = request()->route('image');
        if ($data['cover'] == "on") {
            $result = GoodImage::coverIsOnly($data['good_id'], $id);
            if (!$result) {
                $error = new MessageBag([
                    'title' => '更新失败',
                    'message' => '封面图片已经存在，不能再添加',
                ]);
                return back()->with(compact('error'));
            }
        }
        return $this->formImg()->update($id);
    }

    public function storeImg()
    {
        $data = request()->all(['good_id', 'cover']);
        if ($data['cover'] == "on") {
            $result = GoodImage::coverIsOnly($data['good_id']);
            if (!$result) {
                $error = new MessageBag([
                    'title' => '添加失败',
                    'message' => '封面图片已经存在，不能再添加',
                ]);
                return back()->with(compact('error'));
            }
        }
        return $this->formImg()->store();
    }

    public function destroyImg()
    {
        try {
            $goodsImg = GoodImage::query()->findOrFail(request()->route('image'));
            $path = $goodsImg->image;
            $goodsImg->delete();
            unlink($path);
            $result = [
                'status'  => true,
                'message' => trans('admin.delete_succeeded'),
            ];
        } catch (\Exception $e) {
            $result = [
                'status'  => false,
                'message' => trans('admin.delete_failed') . '，' . $e->getMessage(),
            ];
        }
        return response()->json($result);
    }
}
