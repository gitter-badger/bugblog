<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
	// 验证是否登录
    Route::auth();

    Route::get('/', function () {
	    return view('welcome');
	});

    Route::get('/home', 'HomeController@index');

    /*
	|--------------------------------------------------------------------------
	| 后台管理 Routes
	|--------------------------------------------------------------------------
	|
	*/

    // 文章管理
    Route::group(['prefix' => 'admin'], function () {
    	Route::get('/article', 'Admin\ArticleController@index');
    	Route::get('/article/datas', 'Admin\ArticleController@datas');
        Route::get('/article/{id}', 'Admin\ArticleController@edit');
    	Route::put('/article/{id}', 'Admin\ArticleController@update');
    	Route::delete('/article/{id}', 'Admin\ArticleController@destroy');
    	Route::post('/article', 'Admin\ArticleController@create');
    });

    // 分类管理
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/cat', 'Admin\CatController@index');
        Route::get('/cat/datas', 'Admin\CatController@datas');
        Route::get('/cat/{id}', 'Admin\CatController@edit');
        Route::put('/cat/{id}', 'Admin\CatController@update');
        Route::delete('/cat/{id}', 'Admin\CatController@destroy');
        Route::post('/cat', 'Admin\CatController@create');
    });

    // 公共api
    Route::group(['prefix' => 'api'], function () {
        Route::get('/cat', 'Api\CatController@allCats');
    });
});
