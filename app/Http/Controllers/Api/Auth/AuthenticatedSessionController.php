<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticatedSessionController extends Controller{


    public function store(LoginRequest $request){

        $credentials = $request->all();

        if( ! Auth::attempt( $credentials ) ) {
            return response([
                'message' => 'Invalid credentials'
            ], 401);
        }

        /** @var \App\Models\User */
        $user = Auth::user();

        return response([
                'user' => $user,
                'token' => $user->createToken('api-token')->plainTextToken,
        ]);
    }


    public function me(Request $request){

        $token =   $request->bearerToken() ;
        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken) {
            return response()->json([
                'message' => 'Invalid token'
            ], 401);
        }

        $user = $accessToken->tokenable;

        return response()->json([
            'user' => $user
        ]);
    }


    public function destroy(Request $request){

        $request->user()->tokens()->delete();

        return response()->json([
            "message" => "Logged out successfully !"
        ],200);

    }


}
