<?php

namespace App\Http\Controllers\v1\owner;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::where(['owner_id' => auth()->user()->id])->latest()->get();
        $count = count($stores);
        if ($count > 0) {
            return response()->json([
                'status' => true,
                'message' => "great " . auth()->user()->name . ", your stores have been found",
                'count' => $count,
                'data' => StoreResource::collection($stores),
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Sorry " . auth()->user()->name . ", you don't have any store yet",
            ], 200);
        }
    }

    public function show(Store $store)
    {
        $this->authorize('own', $store);
        return response()->json([
            'status' => true,
            'message' => "great " . auth()->user()->name . ", your stores have been found",
            'data' => new StoreResource($store)
        ],200);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'store_logo' => 'mimes:jpg,png,jpeg|max:1024',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false,'message' => $validator->errors()], 400);
        }

        $input = $request->all();
        $input['owner_id'] = auth()->user()->id;
//        $input['store_logo'] = $request->file('store_logo')->store('stores/logos');
        $store = Store::create($input);
        $message = "$store->name created successfully";

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => new StoreResource($store)
        ], 201);
    }

    public function update(Request $request, Store $store)
    {
        $this->authorize('own', $store);
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'store_logo' => 'mimes:jpg,png,jpeg|max:1024',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $store->name = $request->name;
        $store->description = $request->description;
        $store->email = $request->email;
        $store->phone = $request->phone;
        $store->address = $request->address;

        if ($request->store_logo != null) {
            Storage::delete($store->store_logo);
            $store_logo = $request->file('store_logo')->store('stores/logos');
            $store->store_logo = $store_logo;
        }

        $message = "$store->name updated successfully";

        $store->update();

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => new StoreResource($store),
        ], 200);
    }

    public function destroy(Store $store)
    {
        $this->authorize('own', $store);
        Storage::delete($store->store_logo);
        $message = "$store->name deleted successfully";
        $store->delete();
        return response()->json([
            'status' => true,
            'message' => $message,
        ], 200);
    }
}
