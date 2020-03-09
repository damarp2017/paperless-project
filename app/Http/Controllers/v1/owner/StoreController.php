<?php

namespace App\Http\Controllers\v1\owner;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::where(['owner_id' => auth()->user()->id])->latest()->get();
        $count = count($stores);
        if ($count > 0) {
            return response()->json([
                'message' => "great " . auth()->user()->name . ", your stores have been found",
                'count' => $count,
                'data' => StoreResource::collection($stores),
            ], 200);
        } else {
            return response()->json([
                'message' => "sorry " . auth()->user()->name . ", you don't have any store yet",
            ], 200);
        }
    }

    public function show(Store $store)
    {
        $this->authorize('own', $store);
        return response()->json([
            'message' => "great " . auth()->user()->name . ", your stores have been found",
            'data' => new StoreResource($store)
        ],200);
    }

    public function store(Request $request)
    {

    }
}
