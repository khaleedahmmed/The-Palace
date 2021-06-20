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
    Route::get('users','UserController@index') ;
    Route::post('users','UserController@store') ;
    Route::delete('users/{user}','UserController@destroy') ;
    Route::get('users/{user}','UserController@show') ;
    Route::post('users/{user}','UserController@update') ;

    //admin crud
   // Route::apiResource('users', 'AdminController');
    Route::get('admins','AdminController@index') ;
    Route::delete('admins/{admin}','AdminController@destroy') ;
    Route::get('admins/{admin}','AdminController@show') ;
    Route::post('admins/{admin}','AdminController@update') ;
    Route::post('admins/{admin}/make-admin','AdminController@makeAdmin') ;


    

});

