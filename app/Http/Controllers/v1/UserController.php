<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id.',id',
            'phone' => '',
            'address' => '',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->update();

        return response()->json([
            'status' => true,
            'message' => "successfully update your profiles",
            'data' => new UserResource($user),
        ], 200);
    }

    public function updateAvatar(Request $request)
    {
        $user = Auth::user();
        $rules = [
//            'image' => 'required|mimes:jpg,png,jpeg|max:1024',
            'image' => 'required|mimes:jpg,png,jpeg|max:3072',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        if ($request->image != null) {
            $response = cloudinary()->upload($request->file('image')->getRealPath(),
                array("folder" => "user", "overwrite" => TRUE, "resource_type" => "image"))->getSecurePath();
            $user->image = $response;
        }

        $user->update();
        return response()->json([
            'status' => true,
            'message' => "successfully update your image profiles",
            'data' => new UserResource($user),
        ], 200);
    }
}
