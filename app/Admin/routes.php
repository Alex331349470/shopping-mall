<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->get('users', 'UsersController@index');

    $router->get('goods','GoodsController@index');
    $router->get('goods/create', 'GoodsController@create');
    $router->post('goods','GoodsController@store');
    $router->get('goods/{id}/edit','GoodsController@edit');
    $router->put('goods/{id}','GoodsController@update');

    $router->get('ads','AdsController@index');
    $router->get('ads/create','AdsController@create');
    $router->post('ads','AdsController@store');
    $router->get('ads/{id}/edit', 'AdsController@edit');
    $router->put('ads/{id}', 'AdsController@update');

    $router->resource('bonuses', \App\Admin\Controllers\BonusesController::class);

    $router->get('categories','CategoriesController@index');
    $router->get('categories/create','CategoriesController@create');
    $router->post('categories','CategoriesController@store');
    $router->get('categories/{id}/edit', 'CategoriesController@edit');
    $router->put('categories/{id}', 'CategoriesController@update');

    $router->get('orders', 'OrdersController@index')->name('admin.orders.index');
    $router->get('orders/{order}', 'OrdersController@show')->name('admin.orders.show');
    $router->post('orders/{order}/ship', 'OrdersController@ship')->name('admin.orders.ship');
    $router->get('orders/{order}/edit', 'OrdersController@edit')->name('admin.orders.edit');
    $router->put('orders/{order}', 'OrdersController@update')->name('admin.orders.update');

});
