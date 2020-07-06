<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [
    'as'    =>  'app',
    'uses'  =>  'AppController@index',
]);

Route::group(['prefix' => 'auth'], function(){
    Route::post('/do_login', [
        'as'    =>  'doLogin',
        'uses'  =>  'AuthController@do_login',
    ]);

    Route::get('/logout', [
        'as'    =>  'doLogout',
        'uses'  =>  'AuthController@do_logout',
    ]);
    
});

