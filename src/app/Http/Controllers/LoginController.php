<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {
        // Put the user input into a variable after performing validation
        $login = $request->all();

        $validator = Validator::make($login, [
            'email' => 'email|string|required|max:255',
            'password' => 'required|string|min:8|max:64'
        ]);

        // Return appropriate error if email is taken or passwords don't match
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        };

        // Handle the user providing wrong credentials
        if (!Auth::attempt($login)) {
            return response()->json(['error' => 'bad credentials'], 200);
        };

        // Create the access token for the currently authenticated user
        // Method createToken() actually exists
        $accessToken = Auth::user()->createToken('authToken')->accessToken;

        // return back the user's data and the access token
        return response([
            "userData" => Auth::user(),
            "accessToken" => $accessToken
        ]);
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user]);
    }
}
