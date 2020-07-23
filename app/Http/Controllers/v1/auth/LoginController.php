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
            $user->fcm_token = \request('fcm_token');
            $user->update();
            if ($user->email_verified_at !== null) {
                $message = "Login Successfull";
                return response()->json([
                    'status' => true,
                    'message' => $message,
                    'data' => $user
                ], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Please verify your email first'], 400);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Your credentials does not match', 'data' => (object)[]], 401);
        }
    }
}
