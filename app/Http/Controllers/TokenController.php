<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//I installed "tymon/jwt-auth" package to manage JWT
use JWTAuth;


class TokenController extends Controller
{

    /**
     * Return the access token (JWT).
     *
     * @return \Illuminate\Http\Response
     */
    public function getToken()
    {
        
        //Because this API has no need to validate. I used the bypass below...
        $credentials = array(
            "email" => "usuario",
            "password" => "usuario"
        );

        if (! $token = JWTAuth::attempt($credentials) ) {
            
            return response()->json([
                'success'=> 'false',
                'msg' => 'Unauthorized'
            ], 401);
        }        

        return response()->json([
            'success'=> 'true',
            'msg' => 'You have been authorized',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
        
    }

}
