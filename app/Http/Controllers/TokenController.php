<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;


class TokenController extends Controller
{


    public function getToken()
    {
        
        //$credentials = request(['email', 'password']);
        $credentials = array(
            "email" => "usuario",
            "password" => "usuario"
        );

        if (! $token = JWTAuth::attempt($credentials) ) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }        

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
        
    }

}
