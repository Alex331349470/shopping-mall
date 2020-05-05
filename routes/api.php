<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function () {
    Route::get('version',function (){
        return 'this is version 1';
    });
    Route::middleware('throttle:'.config('api.rate_limits.sign'))
        ->group(function (){
            //小程序注册以及登录
            Route::post('authorizations','AuthorizationsController@store')
                ->name('authorizations.store');

            // 刷新token
            Route::put('authorizations/current', 'AuthorizationsController@update')
                ->name('authorizations.update');

            // 删除token
            Route::delete('authorizations/current', 'AuthorizationsController@destroy')
                ->name('authorizations.destroy');

            Route::get('authorizations/access_token', 'AuthorizationsController@getAccessToken')
                ->name('authorizations.access_token');
        });

    Route::middleware('throttle:'.config('api.rate_limits.access'))
        ->group(function (){
            // 登录后可以访问的接
            // 分类列表
            Route::get('categories', 'CategoriesController@index')
                ->name('categories.index');
            //单个id分类下的二级分类
            Route::get('categories/{category}/directories','CategoriesController@directory')
                ->name('directories.directory');
            //获取分类下所有商品
            Route::get('categories/{category}/goods','CategoriesController@goodIndex')
                ->name('goods.index');

            //获取单个id商品详情
            Route::get('goods', 'GoodsController@hotIndex')
                ->name('good.hotIndex');
            //获取轮播图以及url
            Route::get('ads','AdsController@index')
                ->name('ads.index');
            //获取单个商品评论图片
            Route::get('goods/{good}/reply_images'.'GoodsController@replyImageIndex')
                ->name('replies.images.index');
            //获取单个商品评论
            Route::get('goods/{good}/replies','GoodsController@replyIndex')
                ->name('good.replies');
            //商品搜索
            Route::post('goods/search','GoodsController@index')
                ->name('goods.search,index');

            //用户认证API
            Route::middleware('auth:api')->group(function (){
                //登录用户信息
                Route::get('user', 'AuthorizationsController@me')
                    ->name('user.me');
                //用户收益表
                Route::get('user/bonuses', 'BonusesController@index')
                    ->name('user.bonuses.index');
                //用户收益总和
                Route::get('user/bonuses/total','BonusesController@bonusTotal')
                    ->name('user.bonuses.total');

                Route::get('user/coupon', 'CouponsController@index')
                    ->name('user.coupon.index');

                Route::post('user/coupon','CouponsController@store')
                    ->name('user.coupon.store');
                //上传图片
                Route::post('images', 'ImagesController@store')
                    ->name('images.store');

                //收藏商品
                Route::post('goods/{good}/favorite','GoodsController@favor')
                    ->name('goods.favor');

                //取消收藏
                Route::delete('goods/{good}/favorite','GoodsController@disfavor')
                    ->name('goods.disfavor');

                //商品收藏状态
                Route::get('goods/{good}/favorite/status','GoodsController@favoriteStatus')
                    ->name('goods.favorite.status');
                //用户收藏商品列表
                Route::get('goods/favorites','GoodsController@favorites')
                    ->name('goods.favorites');
                //用户地址列表
                Route::get('user_addresses','UserAddressesController@index')
                    ->name('user.addresses.index');
                //保存用户地址
                Route::post('user_addresses','UserAddressesController@store')
                    ->name('user.addresses.store');
                //单个id用户地址显示
                Route::get('user_addresses/{user_address}','UserAddressesController@show')
                    ->name('user.address.show');
                //单个id用户地址更新
                Route::put('user_addresses/{user_address}','UserAddressesController@update')
                    ->name('user.address.update');
                //单个id用户地址删除
                Route::delete('user_addresses/{user_address}','UserAddressesController@destroy')
                    ->name('user.address.destroy');
                //获取用户默认地址
                Route::get('user_address/default','UserAddressesController@defaultAddress')
                    ->name('user.default.address');
                //设置用户默认地址
                Route::post('user_addresses/{user_address}/default','UserAddressesController@setDefault')
                    ->name('user.address.default');
                //用户购物车添加
                Route::post('cart','CartController@add')
                    ->name('cart.add');
                //用户购物车信息列表
                Route::get('cart','CartController@index')
                    ->name('cart.index');
                //用户购物车信息全列表
                Route::get('cart/index','CartController@cartIndex')
                    ->name('cart.cart.index');
                //更新购物车单个商品信息
                Route::patch('cart/{good}','CartController@update')
                    ->name('cart.update');
                //删除购物车单个商品
                Route::delete('cart/{good}','CartController@destroy')
                    ->name('cart.destroy');
                //订单保存
                Route::post('orders','OrdersController@store')
                    ->name('orders.store');
                //订单列表
                Route::get('orders','OrdersController@index')
                    ->name('orders.index');
                //单个订单详情
                Route::get('orders/{order}','OrdersController@show')
                    ->name('orders.show');
                //单个订单回复信息
                Route::patch('orders/{order}/reply','OrdersController@replied')
                    ->name('order.reply');
                //取消单个订单
                Route::patch('orders/{order}/cancel','OrdersController@cancelled')
                    ->name('order.cancel');
                //确认收货
                Route::put('orders/{order}','OrdersController@received')
                    ->name('order.status.received');
                //提醒发货
                Route::put('orders/{order}/notice', 'OrdersController@notice')
                    ->name('order.status.notice');
                //订单查询
                Route::post('orders/search','OrdersController@search')
                    ->name('orders.search');
                //订单回复列表
                Route::get('orders/replies','OrdersController@replyIndex')
                    ->name('orders.replies.index');
                //订单申请退款
                Route::post('orders/{order}/apply_refund', 'OrdersController@applyRefund')
                    ->name('orders.apply_refund');
                //订单微信支付
                Route::get('payment/{order}/wechat','PaymentsController@payByWechat')
                    ->name('payment.wechat');

                //订单支付宝支付
                Route::get('payment/{order}/alipay','PaymentsController@payByAlipay')
                    ->name('payment.alipay');
                //保存单个订单下单个商品的回复
                Route::post('replies','RepliesController@store')
                    ->name('replies.store');
                //单个订单单个商品的回复列表
                Route::get('replies','RepliesController@index')
                    ->name('replies.index');
                //上传单个回复图片
                Route::post('replies/images', 'ReplyImagesController@store')
                    ->name('replies.images');
                //该api作废
                Route::get('reply_images/{reply_image}','ReplyImagesController@show')
                    ->name('reply_images.show');

            });
            //获取单个id商品详情
            Route::get('goods/{good}', 'GoodsController@show')
                ->name('good.show');
        });

    Route::middleware('auth:api')->group(function (){
        //微信支付支付状态
        Route::get('orders/{order}/wechat','OrdersController@wechatMessage')
            ->name('order.wechat.message');
    });
});
