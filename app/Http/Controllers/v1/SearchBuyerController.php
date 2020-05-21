<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Http\Resources\UserResource;
use App\Store;
use App\User;
use Illuminate\Http\Request;

class SearchBuyerController extends Controller
{
    public function show(User $user) {
        return response()->json([
            'status' => true,
            'message' => 'OK',
            'data' => new UserResource($user)
        ], 200);
    }

    public function search(Request $request)
    {
        $data = $request->get('query');
        $users = User::where('name', 'like', "%{$data}%")
            ->orWhere('email', 'like', "%{$data}%")->get();
        $stores = Store::where('name', 'like', "%{$data}%")->get();
        $count_users = count($users);
        $count_stores = count($stores);
        if ($count_stores || $count_users) {
            return response()->json([
                'status' => true,
                'message' => "data have been found",
                'data' => [
                    'count_users' => $count_users,
                    'count_stores' => $count_stores,
                    'users' => UserResource::collection($users),
                    'stores' => StoreResource::collection($stores)
                ],
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "opss, it seems users or stores that you're looking for is doesn't exist",
                'data' => [],
            ]);
        }
    }
}
