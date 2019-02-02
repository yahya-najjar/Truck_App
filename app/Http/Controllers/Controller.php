<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function notification($title, $body, $token)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $notification = [
            'title' => $title,
            'sound' => true,
            'body' => $body
        ];

//        $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];
        if (is_array($token)) {
            $fcmNotification = [
                'registration_ids' => $token,
                'notification' => $notification,
//            'data' => $extraNotificationData
                'content-available' => true,
                'priority' => "high"
            ];
        } else {
            $fcmNotification = [
                'to' => $token, //single token
                'notification' => $notification,
//            'data' => $extraNotificationData
                'content-available' => true,
                'priority' => "high"
            ];
        }

//        dd($fcmNotification) ;

        $headers = [
            'Authorization: key=' . env('FCM_SERVER_KEY'),
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
//        return true;
    }
}