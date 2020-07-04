<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Notification;
use App\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user()->id;
        $notifications = Notification::where('receiver', $user)->get();
        if ($notifications->count() > 0) {
            return response()->json([
                'status' => true,
                'message' => "your notifications have been found",
                'data' => NotificationResource::collection($notifications),
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "there is no notification for you",
                'data' => [],
            ]);
        }
    }
}
