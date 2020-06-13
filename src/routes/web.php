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

        try{

            $file_name = $json->file_name;
            $file_hash = $json->file_hash;
            $certificate = $json->certificate;

        }catch(Exception $e){

            $file_name = "";
            $file_hash = "";
            $signature = "";

        }



        if( empty( $file_name) || empty($file_hash) || empty($certificate ) ){

            return [

                "error" => "true",
                "error_message" => "Missing Parameters"

            ];

        }

        $last = DB::select('select * FROM blockchain_passports ORDER BY id DESC LIMIT 1 ', []);

        if(empty($last["id"])){

            $last_hash = "";

        }else{

            $last_hash = $s["block_hash"];

        }

        $content = $file_name.$file_hash.$certificate;

        $block_hash = md5($last_hash.$content);

        DB::insert('insert into blockchain_passports (id,file_name,file_hash,certificate,block_hash) values (?,?, ?, ?, ? )', ['', $file_name,$file_hash,$certificate,$block_hash]);

        $last = DB::select('select * FROM blockchain_passports ORDER BY id DESC LIMIT 1 ', []);

        return [

            "error" => "false",
            "error_message" => "",
            "id_passport" => $last["id"]

        ];

    }

});

Route::get('/blockchain/passport/read/{id}', function ($id) {

    if(empty($id)){

        return [

            "error" => "true",
            "error_message" => "Missing Parameters"

        ];

    }

    $passport = DB::select('select * FROM blockchain_passports WHERE id = ? ', [$id]);

    if(empty($id["id"])){

        return [

            "error" => "true",
            "error_message" => "Passport not found with id:".$passport["id"]

        ];

    }

    return [

        "error" => "false",
        "error_message" => "",
        "passport_requested" => $id,
        "file_name" => $passport["file_name"],
        "file_hash" => $passport["file_hash"],
        "block_hash" => $passport["block_hash"],

    ];

    // return 'Received: '. $data;

});

Route::get('/blockchain/document/add', function () {

    $data = file_get_contents("php://input"); // json_decode();

    return 'Received: '. $data;

});

Route::get('/blockchain/document/read', function () {

    $data = file_get_contents("php://input"); // json_decode();

    return 'Received: '. $data;

});

