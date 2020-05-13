<a class='btn btn-xs action-btn btn-info grid-row-refuse' href="{{ route("goods.index") }}?type=1"><i class='fa fa-list'>全部{{ $info['total_all'] }}</i></a>
@if($info['total_hundred'] > 0)
<a class='btn btn-xs action-btn btn-warning grid-row-refuse' href="{{ route("goods.index") }}?type=2"><i class='fa fa-phone'>100 ~ 200库存{{ $info['total_hundred'] }}</i></a>
@endif
@if($info['total_fifty'] > 0)
<a class='btn btn-xs action-btn btn-warning grid-row-refuse' href="{{ route("goods.index") }}?type=3"><i class='fa fa-warning'>50 ~ 99库存{{ $info['total_fifty'] }}</i></a>
@endif
@if($info['total_zero'] > 0)
<a class='btn btn-xs action-btn btn-danger grid-row-refuse' href="{{ route("goods.index") }}?type=4"><i class='fa fa-error'>0 ~ 49库存{{ $info['total_zero'] }}</i></a>
@endif
