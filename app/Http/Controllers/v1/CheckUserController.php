<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class CheckUserController extends Controller
{
    public function check()
    {
        $user = User::all();
        return response()->json([
            'message' => 'all users found',
            'data' => UserResource::collection($user)
        ], 200);
    }
}
