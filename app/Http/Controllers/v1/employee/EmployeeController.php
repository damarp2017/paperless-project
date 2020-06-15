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
            'data' => (object)[],
        ], 200);

    }

    public function my_workplace(Request $request)
    {
        $employee = Employee::where('user_id', auth()->user()->id)->first();
        if ($employee) {
            $store = Store::where('id', $employee->store_id)->first();
            return response()->json([
                'status' => true,
                'message' => 'your workplace found',
                'data' => [
                    'role' => $employee->role,
                    'store' => new StoreResource($store)
                ]
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => "you didn't have workplace",
            'data' => (object) [],
        ]);
    }
}
