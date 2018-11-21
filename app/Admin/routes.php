<?php

Admin::registerAdminRoutes();

Route::group([
    'namespace' => 'App\Admin\Controllers',
    'prefix' => 'admin',
    'middleware' => ['web', 'admin'],
    'as' => 'admin::'
], function () {
    Route::get('/', 'HomeController@index')->name('main');
    Route::post('/upload/image', 'UploadController@image')->name('upload.image');
    Route::post('/upload/cover', 'UploadController@cover')->name('upload.cover');
    Route::delete('/upload/cover', 'UploadController@deleteCover')->name('upload.delete_cover');


    ///
    Route::group([
        'middleware' => ['admin.check_permission']
    ], function () {
        /// 商品管理
        Route::group([
            'namespace' => 'Items'
        ], function () {
            Route::get('items/warning', 'ItemController@warning')->name('items.warning');
            Route::get('items/recycle', 'ItemController@recycle')->name('items.recycle');
            Route::get('items/reduction/{item}', 'ItemController@reduction')->name('items.reduction');
            Route::get('items/sell','ItemController@sell')->name('items.sell');
            Route::get('items/stock','ItemController@stock')->name('items.stock');
            Route::post('items/{item}/change/','ItemController@change')->name('items.change');
            Route::put('items/warning', 'ItemController@warning')->name('items.warning.update');
            Route::resource('items', 'ItemController')->except('show');
            Route::resource('categories', 'CategoryController')->except('show');
        });

        /// 订单管理
        Route::group([
            'namespace' => 'Orders'
        ], function () {
            Route::get('/general_trend', 'OrderController@General_trend');
            Route::get('/statistics', 'OrderController@statistics')->name('orders.statistics');
            Route::get('/orders', 'OrderController@index')->name('orders.index');
            Route::get('/paying', 'OrderController@paying')->name('orders.paying');
            Route::get('/delivering', 'OrderController@delivering')->name('orders.delivering');
            Route::get('/receiving', 'OrderController@receiving')->name('orders.receiving');
            Route::get('/commenting', 'OrderController@commenting')->name('orders.commenting');
            Route::get('/finish', 'OrderController@finish')->name('orders.finish');
            Route::get('/orders/{order}', 'OrderController@show')->name('orders.show');
            Route::put('/orders/{order}/modify_price', 'OrderController@modifyPrice')->name('orders.modify_price');
            Route::put('/orders/{order}/deliver', 'OrderController@deliver')->name('orders.deliver');
            Route::delete('/orders/{order}', 'OrderController@destroy')->name('orders.destroy');

            ///
            Route::get('/refunds', 'RefundController@index')->name('refunds.index');
            Route::put('/refunds/{order_refund}/agree', 'RefundController@agree')->name('refunds.agree');
            Route::put('/refunds/{order_refund}/refuse', 'RefundController@refuse')->name('refunds.refuse');

            ///
            Route::resource('comments', 'CommentController')->except(['create', 'edit']);

        });

        /// 商城设置
        Route::group([
            'namespace' => 'Mall'
        ], function () {
            Route::resource('afterSaleRule', 'AfterSaleRuleController')->only(['index','update']);
            Route::resource('freightRule', 'FreightRuleController')->only(['index','update']);
            Route::resource('service', 'ServiceController')->only(['index','update']);
            Route::resource('banners', 'BannerController')->except('show');
            Route::resource('navigations', 'NavigationController')->except('show');
            Route::resource('recommends', 'RecommendController')->only(['index', 'store', 'destroy']);
            Route::resource('/about', 'AboutController')->only(['index', 'update']);
        });

        /// 用户管理
        Route::group([
            'namespace' => 'Users'
        ], function () {
            Route::get('checkName','UserLevelController@checkName')->name('userLevels.checkName');
            Route::get('checkLevel','UserLevelController@checkLevel')->name('userLevels.checkLevel');
            Route::resource('users', 'UserController')->only(['index','edit','update']);
            Route::resource('userLevels','UserLevelController');
            Route::resource('userRules', 'UserRuleController')->only(['index','update']);
        });

        /// 店铺管理
        Route::group([
           'namespace' => 'Shop'
        ],function (){
            Route::get('shop','ShopController@index')->name('shops.index');
            Route::get('shop/{shop}/show','ShopController@show')->name('shop.show');
        });

        /// 秒杀商品管理
        Route::group([
            'namespace' => 'Secondk'
        ],function(){
            ///秒杀分类
            Route::resource('mcategory','McategoryController');

            ///秒杀专题
            Route::resource('topics', 'TopicController');

            //秒杀会场
            Route::resource('meets','MeetController');
        });
    });
});