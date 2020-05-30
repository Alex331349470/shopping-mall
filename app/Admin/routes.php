<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    // 会员管理
    $router->resource('wx/users', wx\UserController::class);
    // 等级设置
    $router->resource('wx/levels', wx\UserInfoController::class);
    // 绩效管理
    $router->resource('wx/commission', wx\BonusController::class);
    $router->post('wx/commission/flush', 'wx\BonusController@flush')->name('commission.flush');
    $router->get('commissions/{commission}/{month}', 'wx\BonusController@infoList')->name('commission.info.list');
    // 订单管理
    $router->resource('wx/orders', wx\OrderController::class);
    $router->get('orders/{order}', 'wx\OrderController@infoList')->name('order.info.list');
    $router->post('orders/{order}/ship', 'wx\OrderController@ship')->name('admin.orders.ship');
    $router->post('orders/{order}/refund', 'wx\OrderController@handleRefund')->name('admin.orders.handle_refund');
    $router->get('orders/{order}/received', 'wx\OrderController@received')->name('admin.orders.received');
    // 商品管理
    // 商品
    $router->resource('wx/goods', wx\GoodsController::class);
    // 图集
    $router->get('goods/{goods}/images', 'wx\GoodsController@imageList')->name('images.index');
    $router->get('goods/{goods}/images/create', 'wx\GoodsController@createImg')->name('images.create');
    $router->post('goods/{goods}/images', 'wx\GoodsController@storeImg')->name('images.store');
    $router->get('goods/{goods}/images/{image}/edit', 'wx\GoodsController@editImg')->name('images.edit');
    $router->put('goods/{goods}/images/{image}', 'wx\GoodsController@updateImg')->name('images.update');
    $router->delete('wx/images/{image}', 'wx\GoodsController@destroyImg')->name('images.destroy');
    // 分类
    $router->resource('wx/categories', wx\CategoryController::class);
    // 销售属性
    $router->resource('specifications', wx\SpecController::class);
    // 广告管理
    $router->resource('wx/advertises', wx\AdController::class);
    // 评论管理
    $router->resource('wx/reply', wx\ReplyController::class);

});
