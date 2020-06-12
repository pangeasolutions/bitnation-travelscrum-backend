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

use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/test', function ($request) {

    /*
    $users = DB::select('select * git commfrom users where id = ?', [1]);
    return 'hello user 1: '.var_dump($users);
    */

    $data = $request->all();

    return 'Received: '. $data;

});

Route::get('/blockchain/passport/create', function () {

    $data = $request->all();

    return 'Received: '. $data;

});
