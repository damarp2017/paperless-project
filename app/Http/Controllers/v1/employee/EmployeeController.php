<?php

namespace App\Http\Controllers\v1\employee;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Store;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $data = Employee::where('user_id', auth()->user()->id)->first();

        if ($data) {
            $store = Store::where('id', $data->store_id)->first();
            return response()->json([
                'status' => true,
                'message' => 'OK',
                'data' => new StoreResource($store)
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'OK',
            'data' => (object) [],
        ], 200);

    }
}
