<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke()
    {
        $data = request()->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $data['role'] = 'admin';
        
        $user = User::create($data);

        return response()->json([
            'data' => ['message' => 'Administrator created']
        ]);
    }
}
