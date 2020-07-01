<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class TestFCMController extends Controller
{
    public function test()
    {
        $product = Product::all()->last();
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody('Hello world')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['product' => $product]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = "eSlIJ9WUSba8xdEbDNZsIz:APA91bERSXSmxqvfw44jirQm2WUfS-gVrEdmjhrfbcDvwC5Kw08eYAsO3qweqplQg8Z46dgbiaEJH_kmnPSKlaeRivWjQ0GILOjuNEPej0DxuVTYsJUfII6eZxB4v14WKlvhkBjW2R6r";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

// return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

// return Array (key : oldToken, value : new token - you must change the token in your database)
        $downstreamResponse->tokensToModify();

// return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

// return Array (key:token, value:error) - in production you should remove from your database the tokens
        $downstreamResponse->tokensWithError();
    }
}
