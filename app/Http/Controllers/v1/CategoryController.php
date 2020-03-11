<?php

namespace App\Http\Controllers\v1;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();
            return response()->json([
                'status' => false,
                'message' => "all categories found",
                'data' => CategoryResource::collection($categories)
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception
            ], 500);
        }
    }

    public function show(Category $category)
    {
        try {
            $category = Category::find($category)->first();
            return response()->json([
                'status' => false,
                'message' => "a category found",
                'data' => new CategoryResource($category)
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'name' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 400);
            }

            $input = $request->all();
            $category = Category::create($input);
            $message = "$category->name created successfully";
            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => new CategoryResource($category)
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception
            ], 500);
        }
    }

    public function update(Request $request, Category $category)
    {
        try {
            $rules = [
                'name' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ], 400);
            }
            $category = Category::find($category)->first();
            $category->name = $request->name;
            $category->update();
            $message = $category->name . " updated successfully";
            return response()->json([
                'status' => false,
                'message' => $message,
                'data' => new CategoryResource($category)
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception
            ], 500);
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category = Category::find($category)->first();
            $category->delete();
            $message = $category->name . " deleted successfully";
            return response()->json([
                'status' => true,
                'message' => $message,
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception
            ], 500);
        }
    }
}
