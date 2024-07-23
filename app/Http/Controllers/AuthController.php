<?php

namespace App\Http\Controllers;

use App\Exceptions\Unauthorized;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    
    public function login(Request $request) {
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $data['username'])->where('password', $data['password'])->first();
        if (! $user) {
            throw new Unauthorized('Unauthorized', ['login' => 'invalid credentials']);
        }
        
        $token = JWTAuth::fromUser($user);
        Auth::login($user);

        return $this->respondWithToken($token);
    }

    public function respondWithToken($token) {
        return response()->json([
            'data' => [
                'token_user' => $token
            ]
        ]);
    }
}
