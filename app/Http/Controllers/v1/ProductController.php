<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $count = count($products);
        if ($count > 0) {
            return response()->json([
                'status' => true,
                'message' => "great, all products have been found",
                'count' => $count,
                'data' => ProductResource::collection($products),
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Sorry, we don't have any product yet",
                'data' => []
            ], 200);
        }
    }

    public function search(Request $request)
    {
        $data = $request->get('query');
        $products = Product::where('name', 'like', "%{$data}%")->get();
        $count = count($products);
        if ($count) {
            return response()->json([
                'status' => true,
                'message' => "data products have been found",
                'count' => $count,
                'data' => ProductResource::collection($products)
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "opss, it seems products that you're looking for is doesn't exist",
                'data' => [],
            ]);
        }
    }

    public function show(Product $product)
    {
        return response()->json([
            'status' => true,
            'message' => "great, " . $product->name ." has been found",
            'data' => new ProductResource($product),
        ], 200);
    }

//    public function get_by_id(Product $product) {
//        return response()->json([
//            'status' => true,
//            'message' => 'OK',
//            'data' => $product
//        ]);
//    }


}
