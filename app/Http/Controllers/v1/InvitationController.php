<?php

namespace App\Http\Controllers\v1;

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
                    'data' => (object)[]
                ], 200);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception,
            ], 500);
        }
    }
}
