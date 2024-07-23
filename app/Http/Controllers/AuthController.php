<?php

namespace App\Http\Controllers;

use App\Exceptions\Unauthorized;
use App\Http\Middleware\ErrorIfGuest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller implements HasMiddleware
{
    public static function middleware() {
        return [
            new Middleware(ErrorIfGuest::class, except: ['login'])
        ];
    }
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
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'logout']);
    }
    public function refresh() {
        return $this->respondWithToken(auth()->refresh());
    }
    public function user() {
        return response()->json(auth()->user());
    }

    public function respondWithToken($token) {
        return response()->json([
            'data' => [
                'token_user' => $token
            ]
        ]);
    }
}
