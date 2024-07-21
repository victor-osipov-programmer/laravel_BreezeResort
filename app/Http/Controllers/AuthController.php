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
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->where('password', $data['password'])->first();
        if (! $user) {
            throw new Unauthorized();
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
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Config::get('jwt.ttl')
        ]);
    }
}
