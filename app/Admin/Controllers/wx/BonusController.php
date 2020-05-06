<?php

namespace App\Admin\Controllers\wx;

use App\Admin\Extensions\BonusExcleExpoter;
use App\Admin\Extensions\BonusFlush;
use App\Admin\Extensions\CommissionInfoList;
use App\Admin\Extensions\ModelList;
use App\Models\Bounse;
use App\Models\User;
use App\Models\UserInfo;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BonusController extends AdminController
{
    use ValidatesRequests;
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '绩效管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Bounse());
        $grid->model()->join('users', 'user_id', '=', 'users.id')->join('user_infos', 'users.id', '=', 'user_infos.user_id', 'left')->groupByRaw('left(bounses.created_at,7),bounses.user_id,user_infos.type')->selectRaw('users.id,name,phone,left(bounses.created_at,7) as year_month1,user_infos.type as user_type,sum(bonus) as bonus')->orderByRaw('year_month1 desc,id desc');

        $grid->column('id', __('Id'));
        $grid->column('name', __('姓名'));
        $grid->column('phone', __('手机号'));
        $grid->column('user_type', __('用户类型'))->display(function ($value) {
            switch ($value) {
                case '0':
                    return '普通客户';
                case '1':
                    return '二级代销';
                case '2':
                    return '一级代销';
                default:
                    return '未知异常';
            }
        });
        $grid->column('bonus', __('分佣金额'));
        $grid->column('year_month1', __('月份'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableEdit();
            $actions->disableDelete();
            $actions->disableView();
            $actions->add(new BonusFlush($actions->row->id, $actions->row->year_month1, '一键清除'));
            $actions->add(new CommissionInfoList($actions->row->id, $actions->row->year_month1, 'commission.info.list', '绩效详情'));
        });
        $grid->exporter(new BonusExcleExpoter());
        $grid->disableCreateButton();
        $grid->filter(function (Grid\Filter $filter) {
            $filter->disableIdFilter();
            $filter->like('name', '姓名');
            $filter->equal('phone', '手机号');
        });
        return $grid;
    }

    public function infoList($id, $month, Content $content)
    {
        $user = User::query()->findOrFail($id);
        $year_month = $month;
        $start_month = $year_month . "-01 00:00:00";
        $end_month = date('Y-m-d H:i:s', strtotime('+1 month', strtotime($start_month)));
        $total_info = ['start_time' => $start_month, 'end_time' => $end_month];
        $bonuses = Bounse::query()->with("order")->where('user_id', $id)
            ->whereBetween('created_at', [$start_month, $end_month])->get();
        $total_info['total_count'] = $bonuses->count();
        $total_info['total_account'] = $bonuses->sum('bonus');
        $total_info['year_month'] = $year_month;
        return $content
            ->title($user->name . " " . $this->title)
            ->description($this->description['index'] ?? trans('admin.list'))
            ->body(view('admin.bonuses.show', ['bonuses' => $bonuses, 'user' => $user, 'total_info' => $total_info]));
    }

    protected function infoGrid($user_id, $year_month)
    {
        $grid = new Grid(new Bounse());
        $start_month = $year_month . "-01 00:00:00";
        $end_month = date('Y-m-d H:i:s', strtotime('+1 month', strtotime($start_month)));
        $grid->model()->with("order")->where('user_id', $user_id)
            ->whereBetween('created_at', [$start_month, $end_month]);

        $grid->column('id', __('Id'));
        $grid->column('bonus', __('提成'));
        $grid->column('created_at', '操作时间');
        $grid->column('order.no', '订单编号');
        $grid->column('order_id', '订单详情链接')->display(function ($value) {
            $url = route('order.info.list', [$value]);
            return "<a href='{$url}'>点击查看</a>";
        });

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableAll();
        });
        $grid->disableFilter();
        $grid->disableCreateButton();
        $grid->disableExport();
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
        $bonus_collect = Bounse::query()->join('users', 'user_id', '=', 'users.id', 'left')->join('orders', 'order_id', '=', 'orders.id', 'left')->where('user_id', $id)->select([
            'bonuses.id',
            'name',
            'bonus',
            'no',
            'total_amount',
            'bonuses.created_at'
        ])->get();
        foreach ($bonus_collect as $bonus) {
            $show = new Show($bonus);

            $show->field('id', __('Id'));
            $show->field('user_id', __('User id'));
            $show->field('order_id', __('Order id'));
            $show->field('user_type', __('User type'));
            $show->field('bonus', __('Bonus'));
            $show->field('created_at', __('Created at'));
            $show->field('updated_at', __('Updated at'));
        }


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Bounse());

        $form->number('user_id', __('User id'));
        $form->number('order_id', __('Order id'));
        $form->text('user_type', __('User type'));
        $form->decimal('bonus', __('Bonus'))->default(0.00);

        return $form;
    }

    public function flush(Request $request)
    {
        $data = request()->all(['user_id', 'year_month']);
        $this->validate($request, [
            'user_id' => 'required',
            'year_month' => 'required',
        ]);

        $result = Bounse::query()->where('user_id', $data['user_id'])->where(DB::raw("left(created_at, 7)"), $data['year_month'])->update(['bonus' => 0]);
        return redirect()->back();
    }
}
