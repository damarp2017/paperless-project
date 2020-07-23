<?php

namespace App\Http\Controllers\v1\auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => ['required', 'string', 'max:50'],
                'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'fcm_token' => [''],
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
                'data' => (object) []
            ], 400);
        }
        $input = $request->all();
        $input['api_token'] = Str::random(80);
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->sendApiEmailVerificationNotification();
        $message = 'Email verification sent, please check your email';
        return response()->json(['status' => true,'message' => $message, 'data' => (object) []], 201);
    }
}
