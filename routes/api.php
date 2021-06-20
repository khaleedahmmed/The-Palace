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

    

});

