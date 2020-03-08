<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class ApiVerifyEmail extends VerifyEmailBase
{
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute('api.verification.verify',
            Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey()]
        );
    }
}
