<?php

namespace App\Http\Controllers\v1\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            if ($user->email_verified_at !== null) {
                $message = "Login Successfull";
                return response()->json([
                    'message' => $message,
                    'data' => $user
                ], 200);
            } else {
                return response()->json(['message' => 'Please verify your email first'], 401);
            }
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
