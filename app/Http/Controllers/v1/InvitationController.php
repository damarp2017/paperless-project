<?php

namespace App\Http\Controllers\v1;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvitationInResource;
use App\Invitation;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function index()
    {
        try {
            $invitations = Invitation::where('to', auth()->user()->id)->get();
            $count = count($invitations);
            if ($count > 0) {
                return response()->json([
                    'status' => true,
                    'message' => "great " . auth()->user()->name . ", invitations for you have been found",
                    'count' => $count,
                    'data' => InvitationInResource::collection($invitations),
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => "Sorry " . auth()->user()->name . ", there is no invitation for you",
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

    public function accept($invitation)
    {
        if ($this->checkEmployee()) {
            return response()->json([
                'status' => false,
                'message' => "sorry, you registered as employee",
                'data' => (object) []
            ], 200);
        }
        $invitation = Invitation::where('id', $invitation)->first();
        try {
            if ($invitation) {
                $invitation->status = true;
                $invitation->update();

                $employee = new Employee();
                $employee->store_id = $invitation->requested_by_store;
                $employee->user_id = $invitation->to;
                $employee->role = $invitation->role;
                $employee->save();

                return response()->json([
                    'status' => true,
                    'message' => "great " . auth()->user()->name . ", you have been accepted the invitation",
                    'data' => new InvitationInResource($invitation)
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => "not found",
            ], 404);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception,
            ], 500);
        }
    }

    public function reject($invitation)
    {
        $invitation = Invitation::where('id', $invitation)->first();
        try {
            if ($invitation) {
                $invitation->status = false;
                $invitation->update();
                return response()->json([
                    'status' => true,
                    'message' => "great " . auth()->user()->name . ", you have been rejected the invitation",
                    'data' => new InvitationInResource($invitation)
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => "not found",
            ], 404);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception,
            ], 500);
        }
    }

    private function checkEmployee()
    {
        $employee = Employee::where('user_id', auth()->user()->id)->first();
        return ($employee ? true : false);
    }
}
