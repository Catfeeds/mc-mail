<?php

Route::group([
    'namespace' => 'App\Api\Controllers',
    'middleware' => ['api']
], function () {
    /// 认证
    Route::post('/auth/login', 'AuthController@login');
    Route::post('/auth/logout', 'AuthController@logout');
    Route::post('/auth/refresh', 'AuthController@refresh');

    /// 首页
    Route::get('/home', 'HomeController@index');

    /// 商品
    Route::post('/items/search', 'ItemController@search'); //關鍵詞搜索
    Route::get('/items', 'ItemController@index');
    Route::get('/items/recommended','ItemController@recommended');
    Route::get('/items/{item}', 'ItemController@show');
    Route::get('/categories', 'CategoryController@index');
    Route::get('/category/{id}','CategoryController@detail');
    Route::get('/categories/{id}/items', 'CategoryController@show');
    Route::get('/topics/{topic}/items', 'TopicController@show');

    /// 评论
    Route::get('/items/{item}/comments', 'CommentController@show');
    Route::post('/orders/{order}/comments', 'CommentController@store');
    Route::post('/orders/{order}/images', 'CommentController@upload');

    /// 支付通知

    Route::post('/orders/paid_notify', 'OrderController@paidNotify')->name('wechat.paid_notify');
    Route::post('/orders/refund_notify', 'OrderController@refundNotify')->name('wechat.refund_notify');

    ///关于我们
    Route::get('/about/show','AboutController@show')->name('about.show');



    /// 订单
    Route::group([
        'middleware' => ['auth:api']
    ], function () {
        /// 订单
        Route::get('/orders/status', 'OrderController@orderstatus'); //订单状态
        Route::get('/orders', 'OrderController@index');
        Route::post('/orders', 'OrderController@store');
        Route::delete('/orders/{order}', 'OrderController@destroy');
        Route::put('/orders/{order}/pay', 'OrderController@pay');
        Route::put('/orders/{order}/confirm', 'OrderController@confirm');
        Route::get('/orders/{order}', 'OrderController@show');
        Route::get('/orders/{order}/express', 'OrderController@express');

        /// 退款
        Route::post('/orders/{order}/refund', 'RefundController@store');
        Route::get('/refunds', 'RefundController@index');
        Route::get('/refunds/{orderRefund}', 'RefundController@show');
        Route::put('/refunds/{orderRefund}/cancel', 'RefundController@cancel');

        /// 个人收藏
        Route::get('/favorites', 'FavoriteController@index');
        Route::delete('/favorites/{item_id}', 'FavoriteController@destroy');
        Route::post('/favorites/{item_id}', 'FavoriteController@store');

        ///个人信息
        Route::get('users/show','UserController@show');
        Route::post('users/store','UserController@store');

    });
});