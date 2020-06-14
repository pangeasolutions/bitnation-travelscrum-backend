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

// Grouping open routes
Route::prefix('/user')->group(function () {
    Route::post('/login', 'LoginController@login')->name('login');
    Route::post('/register', 'RegisterController@register')->name('register');
});
// Grouping routes that listen for document related actions
Route::group(['prefix' => '/document'], function () {
    Route::post('/ask-permission', 'UserController@askPermission')->name('ask-permission');
    Route::post('/receive-permission', 'UserController@receivePermission')->name('receive-permission');
    Route::get('/fetch-document',  'UserController@fetchDocument')->name('fetch-document');
    Route::post('/issue-prescription', 'UserController@issuePrescription')->name('issue-prescription');
});
