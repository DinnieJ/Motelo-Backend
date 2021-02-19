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

Route::group(['prefix'=>'tenant'], function () {
    Route::post('login', 'Auth\TenantAuthController@login');
    Route::post('register', 'Auth\TenantAuthController@register');
    Route::post('logout', 'Auth\TenantAuthController@logout')->middleware(['assign.guard:tenant', 'auth.jwt']);
    Route::get('test', 'TestController@tenantTest')->middleware(['assign.guard:tenant', 'auth.jwt']);
});

Route::group(['prefix' => 'owner'], function () {
    Route::post('login', 'Auth\OwnerAuthController@login');
    Route::post('logout', 'Auth\OwnerAuthController@logout');
    Route::post('register', 'Auth\OwnerAuthController@register');
});

Route::post('upload', 'TestController@uploadFile');
