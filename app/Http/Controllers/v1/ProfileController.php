<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::where('id', auth()->user()->id)->first();
        return response()->json([
            'status' => true,
            'message' => "Your profile found",
            'data' => new UserResource($user)
        ]);
    }

//    public function update(Request $request, User $user)
//    {
//        $user = User::where('id', auth()->user()->id)->first();
//
//        $rules = [
//            'name' => ['required', 'string', 'max:191'],
//            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
//            'password' => ['', 'string', 'min:8'],
//            'phone' => [''],
//            'address' => [''],
//            'image' => ['', 'images', 'mimes:jpg,png,jpeg|max:1024']
//        ];
//
//        $validator = Validator::make($request->all(), $rules);
//
//        if ($validator->fails()) {
//            return response()->json([
//                'status' => false,
//                'message' => $validator->errors()
//            ], 400);
//        }
//    }
}
