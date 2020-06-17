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
        try {
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
                    'status' => true,
                    'message' => "Sorry " . auth()->user()->name . ", you don't have any store yet",
                    'data' => []
                ], 200);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception,
            ], 500);
        }
    }

    public function show(Store $store)
    {
//        $this->authorize('own', $store);
        try {
            return response()->json([
                'status' => true,
                'message' => "great " . auth()->user()->name . ", your stores have been found",
                'data' => new StoreResource($store)
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception,
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'name' => 'required',
                'description' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required',
                'store_logo' => 'required|mimes:jpg,png,jpeg|max:1024',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 400);
            }

            $store = new Store();
            $store->name = $request->name;
            $store->description = $request->description;
            $store->email = $request->email;
            $store->phone = $request->phone;
            $store->address = $request->address;
            $store->owner_id = auth()->user()->id;

            if ($request->store_logo != null) {
                $file = $request->file('store_logo');
                $file_name = date('ymdHis') . "-" . $file->getClientOriginalName();
                $file_path = 'store-logo/' . $file_name;
                Storage::disk('s3')->put($file_path, file_get_contents($file));
                $store->store_logo = Storage::disk('s3')->url($file_path, $file_name);
            }

            $store->save();

            $message = "$store->name created successfully";

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => new StoreResource($store)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e,
                'status' => false
            ], 500);
        }
    }

    public function update(Request $request, Store $store)
    {
//        $this->authorize('own', $store);
        try {
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
                $file = $request->file('store_logo');
                $file_name = date('ymdHis') . "-" . $file->getClientOriginalName();
                $file_path = 'store-logo/' . $file_name;
                Storage::disk('s3')->put($file_path, file_get_contents($file));
                $store->store_logo = Storage::disk('s3')->url($file_path, $file_name);
//                Storage::delete($store->store_logo);
//                $store_logo = $request->file('store_logo')->store('stores/logos');
//                $store->store_logo = $store_logo;
            }
            $message = "$store->name updated successfully";
            $store->update();
            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => new StoreResource($store),
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => true,
                'message' => $exception,
            ], 500);
        }
    }

    public function destroy(Store $store)
    {
//        $this->authorize('own', $store);
        try {
//            Storage::delete($store->store_logo);
            $message = "$store->name deleted successfully";
            $store->delete();
            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => (object) []
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception,
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $data = $request->get('query');
        $stores = Store::where('name', 'like', "%{$data}%")->where('owner_id', auth()->user()->id)->get();
        $count = count($stores);
        if ($count) {
            return response()->json([
                'count' => $count,
                'status' => true,
                'message' => "your stores have been found",
                'data' => $stores,
            ]);
        } else {
            return response()->json([
                'status' => true,
                'count' => $count,
                'message' => "opss, it seems stores that you're looking for is doesn't exist",
                'data' => (object)[],
            ]);
        }
    }
}
