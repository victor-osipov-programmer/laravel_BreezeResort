<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke()
    {
        $data = request()->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::create($data);
        

        return response()->json([
            'data' => [
                'name' => $user->name,
                'email' => $user->email
            ],
            'message' => 'created'
        ]);
    }
}
