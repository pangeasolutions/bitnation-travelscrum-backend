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

Route::get('/test', function () {

    /*
    $users = DB::select('select * git commfrom users where id = ?', [1]);
    return 'hello user 1: '.var_dump($users);
    */

    $data = file_get_contents("php://input"); // json_decode();

    return 'Received: '. $data;

});

Route::get('/blockchain/passport/add', function () {

    $data = file_get_contents("php://input"); //

    $json = json_decode($data);

    if($json == null){

        return [

            "error" => "true",
            "error_message" => "Invalid JSON"

        ];

    }else{

        return $json;

        // return 'Received: '. $data;

    }



});

Route::get('/blockchain/passport/read', function () {

    $data = file_get_contents("php://input"); // json_decode();

    return 'Received: '. $data;

});

Route::get('/blockchain/document/add', function () {

    $data = file_get_contents("php://input"); // json_decode();

    return 'Received: '. $data;

});

Route::get('/blockchain/document/read', function () {

    $data = file_get_contents("php://input"); // json_decode();

    return 'Received: '. $data;

});

