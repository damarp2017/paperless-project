<?php

namespace App\Http\Controllers\v1\owner;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Product;
use App\Stock;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Store $store)
    {
        $this->authorize('own', $store);
        try {
            $stocks = Stock::where('store_id', $store->id)->get();
            $count = count($stocks);
            if ($count > 0) {
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

    public function show(Store $store, Product $product)
    {
        $this->authorize('own', $store);
        try {
            $stock = Stock::where(['store_id' => $store->id, 'product_id' => $product->id])->first();
            if ($stock)
            {
                return response()->json([
                    'status' => true,
                    'message' => "$product->name on $store->name has been found",
                    'data' => new ProductResource($stock)
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'this action is unauthorized'
            ], 403);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception,
            ], 500);
        }
    }

    public function store(Request $request, Store $store)
    {
        $this->authorize('own', $store);
        try {
            $rules = [
                'category_id' => 'required',
                'name' => 'required',
                'description' => '',
                'price' => ['required', 'numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'weight' => ['required', 'numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'status' => 'required',
                'available_online' => 'required',
                'quantity' => ['required', 'numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ], 400);
            }

            $product = new Product();
            $product->category_id = $request->category_id;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->weight = $request->weight;
            $product->status = $request->status;
            $product->available_online = $request->available_online;
            $product->save();

            $stock = new Stock();
            $stock->store_id = $store->id;
            $stock->product_id = $product->id;
            $stock->quantity = $request->quantity;
            $stock->save();

            return response()->json([
                'status' => true,
                'message' => "$product->name has been created",
                'data' => new ProductResource($stock),
            ], 201);

        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception,
            ], 500);
        }
    }
}
