<?php

namespace App\Http\Controllers\v1\owner;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvitationResource;
use App\Invitation;
use App\Store;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvitationController extends Controller
{
    public function index(Store $store)
    {
        $this->authorize('own', $store);
        try {
            $invitations = Invitation::where('requested_by_store', $store->id)->get();
            $count = count($invitations);
            if ($count > 0) {
                return response()->json([
                    'status' => true,
                    'message' => "great " . auth()->user()->name . ", invitation on stores $store->name have been found",
                    'count' => $count,
                    'data' => InvitationResource::collection($invitations),
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => "Sorry " . auth()->user()->name . ", you don't have any invitation yet",
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

    public function invite(Request $request)
    {
        $rules = [
            'role' => 'required',
            'requested_by_store' => 'required',
            'to' => 'required'
        ];

        $store = Store::where('id', $request->requested_by_store)->first();

        $this->authorize('own', $store);

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $invite = new Invitation();
        $invite->requested_by_store = $request->requested_by_store;
        $invite->to = $request->to;
        $invite->role = $request->role;
        if ($request->message != null) {
            $invite->message = $request->message;
        }

        $to = User::where('id',$request->to)->first();

        // check apakah user yang akan diinvite punya store?
        /*
        if ($this->userHasStore($request->to)) {
            return response()->json([
                'status' => true,
                'message' => "$to->name has store, can't be invited",
                'data' => (object) [],
            ], 200);
        }
        */

        // check apakah user yang akan diinvite sudah menjadi employee di store lain
        if ($this->checkEmployee($request->to)) {
            return response()->json([
                'status' => false,
                'message' => "$to->name is an employee on another store",
                'data' => (object) [],
            ], 200);
        }

        // check apakah sudah pernah menginvite dan belum dijawab
        if ($this->isWaitingResponse($store->id, $request->to)) {
            return response()->json([
                'status' => false,
                'message' => "you have invited $to->name, waiting for this user's response",
                'data' => (object) [],
            ], 200);
        }

        $invite->save();

        $message = "invitation has been sent";
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => new InvitationResource($invite)
        ], 201);
    }

    private function checkEmployee($user_id)
    {
        $user = Employee::where('user_id', $user_id)->first();
        return ($user ? true : false);
    }

    private function isWaitingResponse($store_id, $user_id)
    {
        $invitation = Invitation::where('requested_by_store', $store_id)
            ->where('to', $user_id)->where('status', null)->first();
        return ($invitation ? true : false);
    }

    private function userHasStore($user_id)
    {
        $stores = Store::where('owner_id', $user_id)->first();
        return ($stores ? true : false);
    }
}
