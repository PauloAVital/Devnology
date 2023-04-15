<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


# Grupo Token
Route::group(['namespace' => 'Auth'], function (){
    Route::post('login', 'AuthenticateControllerLogin@authenticate');
});

Route::group(['namespace' => 'Api', 'middleware' => 'auth:api'], function (){
    Route::apiResource('User', 'UserController');

    Route::apiResource('ProductBrazilian', 'ProductBrazilianController');
    Route::get('ProductBrazilian/{id}/relation', 'ProductBrazilianController@relation');

    Route::apiResource('ShoppingCart', 'ShoppingCartControler');
    Route::get('ShoppingCart/{id}/relation', 'ShoppingCartControler@relation');

    Route::apiResource('ProductEuropean', 'ProductEuropeanController');
    Route::get('ProductEuropean/{id}/relation', 'ProductEuropeanController@relation');
});

