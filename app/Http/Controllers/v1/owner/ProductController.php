<?php

namespace App\Http\Controllers\v1\owner;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Product;
use App\Stock;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Store $store)
    {
        $this->authorize('own', $store);
        try {
            $products = Product::where('store_id', $store->id)->get();
            $count = count($products);
            if ($count > 0) {
                return response()->json([
                    'status' => true,
                    'message' => "all products on $store->name have been found",
                    'count' => $count,
                    'data' => ProductResource::collection($products),
                ], 200);
            }
            return response()->json([
                'status' => true,
                'message' => "$store->name doesn't has any product yet",
                'data' => []
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
            $product = Product::where(['store_id' => $store->id, 'id' => $product->id])->first();
            if ($product) {
                return response()->json([
                    'status' => true,
                    'message' => "$product->name on $store->name has been found",
                    'data' => new ProductResource($product)
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
                'image' => 'mimes:jpg,png,jpeg|max:1024',
                'description' => '',
                'price' => ['required', 'numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'weight' => ['numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'quantity' => ['numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
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
            $product->store_id = $store->id;
            $product->name = $request->name;

            if ($request->image != null) {
                $file = $request->file('image');
                $file_name = date('ymdHis') . "-" . $file->getClientOriginalName();
                $file_path = 'product/' . $file_name;
                Storage::disk('s3')->put($file_path, file_get_contents($file));
                $product->image = Storage::disk('s3')->url($file_path, $file_name);
            }

            $product->description = $request->description;
            $product->price = $request->price;
            $product->weight = $request->weight;
            if ($request->quantity != null) {
                $product->quantity = $request->quantity;
            }
            $product->save();

            return response()->json([
                'status' => true,
                'message' => "$product->name has been created",
                'data' => new ProductResource($product),
            ], 201);

        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception,
            ], 500);
        }
    }

    public function update(Request $request, Store $store, Product $product)
    {
        $this->authorize('own', $store);
        try {
            $product = Product::where(['store_id' => $store->id, 'id' => $product->id])->first();
            if ($product) {
                $rules = [
                    'category_id' => 'required',
                    'name' => 'required',
                    'image' => 'mimes:jpg,png,jpeg|max:1024',
                    'description' => '',
                    'price' => ['required', 'numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                    'weight' => ['numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                    'status' => '',
                    'available_online' => '',
                    'quantity' => ['numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => $validator->errors()
                    ], 400);
                }

                $product->category_id = $request->category_id;

                $product->name = $request->name;
                $product->description = $request->description;
                $product->price = $request->price;
                $product->weight = $request->weight;

                if ($request->status != null) {
                    $product->status = $request->status;
                }

                if ($request->available_online != null) {
                    $product->available_online = $request->available_online;
                }

                if ($request->image != null) {
                    $file = $request->file('image');
                    $file_name = date('ymdHis') . "-" . $file->getClientOriginalName();
                    $file_path = 'product/' . $file_name;
                    Storage::disk('s3')->put($file_path, file_get_contents($file));
                    $product->image = Storage::disk('s3')->url($file_path, $file_name);
                }

                if ($request->quantity != null) {
                    $product->quantity = $request->quantity;
                }

                $product->save();

                return response()->json([
                    'status' => true,
                    'message' => "$product->name has been updated",
                    'data' => new ProductResource($product),
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'this action is unauthorized',
                ], 403);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception,
            ], 500);
        }
    }

    public function destroy(Store $store, Product $product)
    {
        $this->authorize('own', $store);
        try {
            $product = Product::where(['store_id' => $store->id, 'id' => $product->id])->first();
            if ($product) {
                $product->delete();
                return response()->json([
                    'status' => true,
                    'message' => "$product->name on $store->name successfully deleted",
                    'data' => (object)[]
                ], 200);
            } else {
                return response()->json([
                    'message' => "this action is unauthorized",
                ], 403);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception,
            ], 500);
        }
    }

    public function search(Request $request, Store $store)
    {
        $data = $request->get('query');
        $products = Product::where('name', 'like', "%{$data}%")
            ->where('store_id', $store->id)->get();
        $count = count($products);
        if ($count) {
            return response()->json([
                'count' => $count,
                'status' => true,
                'message' => "your products have been found",
                'data' => $products,
            ]);
        } else {
            return response()->json([
                'status' => true,
                'count' => $count,
                'message' => "opss, it seems products that you're looking for is doesn't exist",
                'data' => (object)[],
            ]);
        }
    }
}
