<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request)
    {
        // Validate the data the user put in
        $validator = Validator::make($request->all(), [
            'email' => 'email|string|required|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed|max:64'
        ]);

        // Return appropriate error if email is taken or passwords don't match
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        };

        $validatedData = $request->all();

        // Hash the password
        $validatedData['password'] = bcrypt($validatedData['password']);

        // Create the user
        $user = User::create($validatedData);

        // Give the user a token
        $token =  $user->createToken('authToken')->accessToken;

        // Return a 'success' response with the email and the token
        return response()->json([
            'userData' => $user,
            'accessToken' => $token
        ]);
    }
}
