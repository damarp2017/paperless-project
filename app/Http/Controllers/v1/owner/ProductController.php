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
        if (isOwner($store) || isStaff($store) || isCashier($store)) {
            $products = Product::where('store_id', $store->id)->get();
            $products_with_discount = Product::where('store_id', $store->id)
                ->where('discount_by_percent', '!=', null)->get();
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
        } else {
            return response()->json([
                'status' => false,
                'message' => "you do not have access",
                'data' => []
            ], 403);
        }

    }

    public function show(Store $store, Product $product)
    {
        if (isOwner($store) || isStaff($store) || isCashier($store)) {
            return response()->json([
                'status' => true,
                'message' => "$product->name on $store->name has been found",
                'data' => new ProductResource($product)
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'you do not have access',
            'data' => (object)[]
        ], 403);
    }

    public function store(Request $request, Store $store)
    {
        if (isOwner($store) || isStaff($store)) {

            $rules = [
                'category_id' => 'required',
                'name' => 'required|max:100',
//                'image' => 'required|mimes:jpg,png,jpeg|max:1024',
                'image' => 'required|mimes:jpg,png,jpeg|max:3072',
                'description' => '',
                'price' => ['required', 'numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
//                'quantity' => ['numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'quantity' => '',
            ];

            $validator = Validator::make($request->all(), $rules);

            if (isNotCategory($request->category_id)){
                return response()->json([
                    'status' => false,
                    'message' => "category not found"
                ], 400);
            }

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

            if ($request->code != null) {
                $product->code = $request->code;
            }

            if ($request->image != null) {
                $response = cloudinary()->upload($request->file('image')->getRealPath(),
                    array("folder" => "product", "overwrite" => TRUE, "resource_type" => "image"))->getSecurePath();
                $product->image = $response;
            }

            $product->description = $request->description;
            $product->price = $request->price;
            $product->quantity = $request->quantity;

//            if ($request->quantity != null) {
//                $product->quantity = $request->quantity;
//            }
            $product->save();

            return response()->json([
                'status' => true,
                'message' => "$product->name has been created",
                'data' => new ProductResource($product),
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => "you do not have access"
            ], 403);
        }

    }

    public function update(Request $request, Store $store, Product $product)
    {
        if (isOwner($store) || isStaff($store) || isCashier($store)) {
//            $product = Product::where(['store_id' => $store->id, 'id' => $product->id])->first();
            $rules = [
                'category_id' => 'required',
                'name' => 'required|max:100',
                'description' => '',
                'price' => ['required', 'numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'status' => '',
//                    'quantity' => ['numeric', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
                'quantity' => '',
            ];

            $validator = Validator::make($request->all(), $rules);


            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ], 400);
            }

            if (isNotCategory($request->category_id)){
                return response()->json([
                    'status' => false,
                    'message' => "category not found"
                ], 400);
            }

            $product->category_id = $request->category_id;

            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;

            if ($request->code != null) {
                $product->code = $request->code;
            }

            $product->quantity = $request->quantity;
            if ($request->status == 'true') {
                $product->status = 1;
            } else {
                $product->status = 0;
            }

            $product->discount_by_percent = $request->discount_by_percent;

//                if ($request->discount_by_percent > 0 && $request->discount_by_percent <= 100) {
//                    $product->discount_by_percent = $request->discount_by_percent;
//                }

            $product->save();

            return response()->json([
                'status' => true,
                'message' => "$product->name has been updated",
                'data' => new ProductResource($product),
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "you do not have access"
            ], 403);
        }
    }

    public function updateImageProduk(Request $request, Store $store, Product $product)
    {
        if (isOwner($store) || isStaff($store)) {
            $rules = [
//                'image' => 'mimes:jpg,png,jpeg|max:1024',
                'image' => 'mimes:jpg,png,jpeg|max:3072',
            ];
            if ($request->image != null) {
                $file = $request->file('image');
                $file_name = date('ymdHis') . "-" . $file->getClientOriginalName();
                $file_path = 'product/' . $file_name;
                Storage::disk('s3')->put($file_path, file_get_contents($file));
                $product->image = Storage::disk('s3')->url($file_path, $file_name);
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ], 400);
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
                'message' => "you do not have access"
            ], 403);
        }
    }

    public function destroy(Store $store, Product $product)
    {
        if (isOwner($store) || isStaff($store)) {
            $product->delete();
            return response()->json([
                'status' => true,
                'message' => "$product->name on $store->name successfully deleted",
                'data' => (object)[]
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "you do not have access"
            ], 403);
        }
    }

    public function search(Request $request, Store $store)
    {
        $data = $request->get('query');
        $products = Product::where('name', 'like', "%{$data}%")
            ->where('store_id', $store->id)->get();
//        $products_with_discount = Product::where('name', 'like', "%{$data}%")
//            ->where('store_id', $store->id)
//            ->where('discount_by_percent', '!=', null)->get();
        $count = count($products);
        if ($count) {
            return response()->json([
                'count' => $count,
                'status' => true,
                'message' => "your products have been found",
                'data' => ProductResource::collection($products),
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

    public function discount_by_percent(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();
        if ($request->discount_by_percent > 0 && $request->discount_by_percent <= 100) {
            $product->discount_by_percent = $request->discount_by_percent;
            $product->update();
            return response()->json([
                'status' => true,
                'message' => "successfully adding discount by percent on product",
                'data' => new ProductResource($product)
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => "discount value must between 0 until 100",
            'data' => (object)[]
        ]);
    }
}
