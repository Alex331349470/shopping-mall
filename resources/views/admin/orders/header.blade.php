<a class='btn btn-xs action-btn btn-info grid-row-refuse' href="{{ route("orders.index") }}?type=1"><i class='fa fa-list'>全部{{ $info['total_all'] }}</i></a>
@if($info['total_notify'] > 0)
<a class='btn btn-xs action-btn btn-warning grid-row-refuse' href="{{ route("orders.index") }}?type=5"><i class='fa fa-phone'>提醒发货{{ $info['total_notify'] }}</i></a>
@endif
@if($info['total_unship'] > 0)
<a class='btn btn-xs action-btn btn-warning grid-row-refuse' href="{{ route("orders.index") }}?type=2"><i class='fa fa-warning'>支付待发货{{ $info['total_unship'] }}</i></a>
@endif
@if($info['total_notify'] > 0)
    <a class='btn btn-xs action-btn btn-warning grid-row-refuse' href="{{ route("orders.index") }}?type=6"><i class='fa fa-ship'>已发货{{ $info['total_delivered'] }}</i></a>
@endif
@if($info['total_unrefund'] > 0)
<a class='btn btn-xs action-btn btn-danger grid-row-refuse' href="{{ route("orders.index") }}?type=3"><i class='fa fa-close'>退款未处理{{ $info['total_unrefund'] }}</i></a>
@endif
@if($info['total_finished'] > 0)
<a class='btn btn-xs action-btn btn-success grid-row-refuse' href="{{ route("orders.index") }}?type=4"><i class='fa fa-eye'>已完成{{ $info['total_finished'] }}</i></a>
@endif
