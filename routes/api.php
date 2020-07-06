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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'admin'], function(){

	Route::get('auth/role', ['uses'  =>  'AuthController@role']);
   
    Route::group(['prefix' => 'menu'], function(){
        Route::get('/', ['uses'  =>  'MenuController@index']);
        Route::post('/store', ['uses'  =>  'MenuController@store']);
        Route::put('/update', ['uses'  =>  'MenuController@update']);
        Route::delete('/delete', ['uses'  =>  'MenuController@destroy']);
    });

    Route::group(['prefix' => 'role'], function(){
        Route::get('/', ['uses'  =>  'RoleController@index']);
        Route::post('/store', ['uses'  =>  'RoleController@store']);
        Route::put('/update', ['uses'  =>  'RoleController@update']);
        Route::delete('/delete', ['uses'  =>  'RoleController@destroy']);
    });

    Route::group(['prefix' => 'user'], function(){
        Route::get('/', ['uses'  =>  'UserController@index']);
        Route::post('/store', ['uses'  =>  'UserController@store']);
        Route::put('/update', ['uses'  =>  'UserController@update']);
        Route::delete('/delete', ['uses'  =>  'UserController@destroy']);
    });

});
