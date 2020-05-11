<?php

namespace App\Http\Controllers\v1\owner;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use App\Store;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Store $store)
    {
        $employees = Employee::where('store_id', $store->id)->get();
        $count = count($employees);
        if ($count > 0) {
            return response()->json([
                'status' => true,
                'message' => "great, all employees on $store->name have been found",
                'count' => $count,
                'data' => EmployeeResource::collection($employees),
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Sorry, we don't have any store yet",
                'data' => []
            ], 200);
        }
    }
}
