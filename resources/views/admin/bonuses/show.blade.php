<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">用户名：{{ $user->name }}</h3>
        <div class="box-tools">
            <div class="btn-group float-right" style="margin-right: 10px">
                <a href="{{ route('commission.index') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> 列表</a>
            </div>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td>起始时间：</td>
                <td>{{ $total_info['start_time'] }}</td>
                <td>结束时间：</td>
                <td>{{ $total_info['end_time'] }}</td>
            </tr>
            <tr>
                <td>累计金额</td>
                <td>{{ $total_info['total_account'] }}</td>
                <td>累计次数</td>
                <td>{{ $total_info['total_count'] }}</td>
            </tr>
            <tr>
                <td>当前会员类型</td>
                <td colspan="3">{{ $user->info->new_type }}</td>
            </tr>
            <tr>
                <td rowspan="{{ $total_info['total_count'] + 1 }}">详情列表</td>
                <td>订单信息</td>
                <td>分佣金额</td>
                <td>订单详情</td>
            </tr>
            @foreach($bonuses as $item)
                <tr>
                    <td>编号：{{ $item->order->no }}<br/>消费金额：￥{{ $item->order->total_amount }}</td>
                    <td>￥{{ $item->bonus }}</td>
                    <td><a href="{{ route('orders.show', $item->order_id) }}" >前往查看</a></td>
                </tr>
            @endforeach
            <!-- 订单发货开始 -->
            <!-- 如果订单未发货，展示发货表单 -->
            @if($total_info['total_account'] > 0)
                <tr>
                    <td colspan="4">
                        <form action="{{ route('commission.flush') }}" method="post" class="form-inline">
                            <!-- 别忘了 csrf token 字段 -->
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('express_company') ? 'has-error' : '' }}">
                                <label for="express_company" class="control-label"></label>
                                <input type="hidden" id="express_company" name="year_month" value="{{ $total_info['year_month'] }}" class="form-control" placeholder="输入物流公司">
                                @if($errors->has('year_month'))
                                    @foreach($errors->get('year_month') as $msg)
                                        <span class="help-block">{{ $msg }}</span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('express_no') ? 'has-error' : '' }}">
                                <label for="express_no" class="control-label"></label>
                                <input type="hidden" id="express_no" name="user_id" value="{{ $user->id }}" class="form-control" placeholder="输入物流单号">
                                @if($errors->has('user_id'))
                                    @foreach($errors->get('user_id') as $msg)
                                        <span class="help-block">{{ $msg }}</span>
                                    @endforeach
                                @endif
                            </div>
                            <button type="submit" class="btn btn-success" id="ship-btn">一键清零</button>
                        </form>
                    </td>
                </tr>
{{--            @else--}}
{{--                <!-- 否则展示物流公司和物流单号 -->--}}
{{--                <tr>--}}
{{--                    <td>物流公司：</td>--}}
{{--                    <td colspan="3">{{ $order->ship_data['express_company'] }}</td>--}}
{{--                    <td>物流单号：</td>--}}
{{--                    <td>{{ $order->ship_data['express_no'] }}</td>--}}
{{--                </tr>--}}
            @endif
            <!-- 订单发货结束 -->
            </tbody>
        </table>
    </div>
</div>
