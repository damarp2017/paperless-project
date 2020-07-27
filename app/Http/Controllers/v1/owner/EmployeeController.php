<?php

namespace App\Http\Controllers\v1\owner;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use App\Invitation;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
                'message' => "Sorry, we don't have any employee yet",
                'data' => []
            ], 200);
        }
    }

    public function updateRole(Request $request, Store $store)
    {
        $employee = Employee::where('store_id', $store->id)->where('user_id', $request->employee_id)->first();

        $rules = [
            'role' => 'required',
            'employee_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $employee->role = $request->role;
        $employee->update();
        return response()->json([
            'status' => true,
            'message' => 'update successfuully',
            'data' => new EmployeeResource($employee)
        ]);
    }

    public function destroy(Store $store, Employee $employee)
    {
        $invitation = Invitation::where('to', $employee->user_id)->where('status', true)->first();
        $invitation->forceDelete();
        $employee->forceDelete();
        return response()->json([
            'status' => true,
            'message' => 'deleted successfuully',
            'data' => new EmployeeResource($employee)
        ]);
    }
}
