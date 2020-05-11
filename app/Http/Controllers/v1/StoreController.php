<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::all();
        $count = count($stores);
        if ($count > 0) {
            return response()->json([
                'status' => true,
                'message' => "great, all stores have been found",
                'count' => $count,
                'data' => StoreResource::collection($stores),
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Sorry, we don't have any store yet",
                'data' => []
            ], 200);
        }
    }

    public function show(Store $store)
    {
        return response()->json([
            'status' => true,
            'message' => "great, " . $store->name ." has been found",
            'data' => new StoreResource($store),
        ], 200);
    }
}
