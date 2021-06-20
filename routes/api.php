<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;

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

//all routes / api here must be api authenticated
Route::group(['middleware' =>'api', 'namespace' => 'Api'], function () {
   
        Route::post('login','AuthController@Login') ; //login
        Route::post('register','AuthController@register') ;
        Route::get('logout','AuthController@logout') ;      
    
    Route::group(['middleware' => 'user'],function (){
       Route::get('profile','ProfileController@index') ;
       Route::post('updateProfile','ProfileController@update') ;    
    });

    //user crud
   // Route::apiResource('users', 'UserController');
   Route::group(['middleware' =>'admin'],function (){

    Route::get('users','UserController@index'); 
    Route::post('users/{user}','UserController@update') ;
    Route::get('users/{user}','UserController@show') ;

    Route::post('users','UserController@store')->middleware('can:user-create');
    Route::delete('users/{user}','UserController@destroy')->middleware('can:user-destroy');

    //admin crud
   // Route::apiResource('users', 'AdminController');
    Route::get('admins','AdminController@index')->middleware('can:admin-index');
    Route::delete('admins/{admin}','AdminController@destroy')->middleware('can:admin-destroy');
    Route::get('admins/{admin}','AdminController@show')->middleware('can:admin-show');
    Route::post('admins/{admin}','AdminController@update')->middleware('can:admin-update');
    Route::post('admins/{admin}/make-admin','AdminController@makeAdmin')->middleware('can:make-admin');
});

    

});

