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

Route::group(['prefix' => 'auth'], function () {
    Route::group(['prefix' => 'tenant'], function () {
        Route::post('login', 'Auth\TenantAuthController@login');
        Route::post('register', 'Auth\TenantAuthController@register');
        Route::post('logout', 'Auth\TenantAuthController@logout')->middleware(['auth.jwt', 'assign.guard:tenant']);
        Route::get('user', 'Auth\TenantAuthController@getAuthUser')->middleware(['auth.jwt', 'assign.guard:tenant']);
    });

    Route::group(['prefix' => 'owner'], function () {
        Route::post('login', 'Auth\OwnerAuthController@login');
        Route::post('logout', 'Auth\OwnerAuthController@logout')->middleware(['auth.jwt', 'assign.guard:owner']);
        Route::post('register', 'Auth\OwnerAuthController@register');
        Route::get('user', 'Auth\OwnerAuthController@getAuthUser')->middleware(['auth.jwt', 'assign.guard:owner']);
    });
});
Route::group(['prefix' => 'tenant'], function () {
    Route::get('test', 'TestController@tenantTest')->middleware(['auth.jwt', 'assign.guard:tenant']);
    Route::post('/comment/add', 'RoomComment\RoomCommentController@addNewComment');
    Route::delete('/comment/delete','RoomComment\RoomCommentController@deleteComment');
    Route::post('/comment/update', 'RoomComment\RoomCommentController@updateComment');
});

Route::group(['prefix' => 'owner'], function () {
    Route::get('test', 'TestController@ownerTest')->middleware(['auth.jwt', 'assign.guard:owner']);
});

Route::post('upload', 'TestController@uploadFile');

Route::group(['prefix' => 'inn'], function () {
    Route::get('/detail/{id}', 'Inn\InnController@getDetailInn');
});
Route::group(['prefix' => 'room'], function () {
    Route::get('/detail/{id}', 'Room\RoomController@getDetailRoom');
});
