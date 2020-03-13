<?php

namespace App\Http\Controllers\v1\owner;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Stock;
use App\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Store $store)
    {
        try {
            $this->authorize('own', $store);
            $stocks = Stock::where('store_id', $store->id)->get();
            $count = count($stocks);
            if ($count > 0)
            {
                return response()->json([
                    'status' => true,
                    'message' => "all products on $store->name have been found",
                    'count' => $count,
                    'data' => ProductResource::collection($stocks),
                ], 200);
            }
            return response()->json([
                'status' => true,
                'message' => "$store->name doesn't has any product yet",
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception,
            ], 500);
        }
    }
}
