<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function search(Request $request)
    {
        $data = $request->get('query');
        $users = User::where('name', 'like', "%{$data}%")
            ->orWhere('email', 'like', "%{$data}%")->get();
        $count = count($users);
        if ($count) {
            return response()->json([
                'count' => $count,
                'status' => true,
                'message' => "users have been found",
                'data' => UserResource::collection($users),
            ]);
        } else {
            return response()->json([
                'status' => true,
                'count' => $count,
                'message' => "opss, it seems users that you're looking for is doesn't exist",
                'data' => [],
            ]);
        }
    }
}
