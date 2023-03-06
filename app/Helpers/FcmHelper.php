<?php

namespace App\Helpers;

use App\Models\MasterStudent;
use App\Models\MasterTokenFcm;
use App\Models\MasterUsers;
use GuzzleHttp\Client;

class FcmHelper
{
    public static function sendNotification($title, $body, $data, $deviceRegistrationToken)
    {
        // Build the notification payload
        $notification = [
            'title' => $title,
            'body' => $body,
            'sound' => 'default',
        ];

        // Build the FCM message
        $message = [
            'notification' => $notification,
            'data' => $data,
            'to' => $deviceRegistrationToken, // Replace with the FCM registration token of the destination device
        ];

        // Send the message
        $options = [
            'http' => [
                'header' => [
                    'Authorization: key=' . env('GOOGLE_FIREBASE_SERVER_KEY'), // replace with your FCM server key
                    'Content-Type: application/json',
                ],
                'method' => 'POST',
                'content' => json_encode($message),
            ],
        ];
        $context = stream_context_create($options);
        $result = file_get_contents('https://fcm.googleapis.com/fcm/send', false, $context);

        // Handle the result
        if ($result === false) {
            return response()->json('Failed to send notification');
        } else {
            return response()->json('Notification sent successfully');
        }
    }
    public static function sendNotificationWithGuzzle(
        $body,
        $data,
        $isManyNotif = true,
        $deviceRegistrationToken = null
    ) {
        // Build the notification payload
        $notification = [
            'title' => 'Pemberitahuan Baru',
            'body' => $body,
            'sound' => 'default',
        ];

        // Build the FCM message
        if ($isManyNotif) {
            $tokens = MasterTokenFcm::pluck('token')->toArray();
            $message = [
                'notification' => $notification,
                'data' => $data,
                'registration_ids' => $tokens,
            ];
        } else {
            $message = [
                'notification' => $notification,
                'data' => $data,
                'to' => $deviceRegistrationToken,
            ];
        }

        // Send the message
        $client = new Client();
        $response = $client->post('https://fcm.googleapis.com/fcm/send', [
            'headers' => [
                'Authorization' => 'key=' . env('GOOGLE_FIREBASE_SERVER_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => $message,
        ]);

        // Handle the response
        $responseBody = json_decode($response->getBody(), true);
        $successCount = $responseBody['success'] ?? 0;
        $failureCount = $responseBody['failure'] ?? 0;
        return ['success' => $successCount, 'failure' => $failureCount];
    }

    public static function sendNotificationWithGuzzleForWeb(
        $title,
        $body,
        $data,
        $isManyNotif = true,
        $deviceRegistrationToken = null,
        $programId = 1
    ) {
        // Build the notification payload
        $notification = [
            'title' => $title,
            'body' => $body,
            'sound' => 'default',
        ];

        // Build the FCM message
        if ($isManyNotif) {
            $tokens = MasterUsers::join('trx_caretakers', 'master_users.id', '=', 'trx_caretakers.user_id')
                ->join('master_token_fcm', 'master_users.id', '=', 'master_token_fcm.id_user')
                ->where('master_users.roles_id', '=', 3)
                ->where('trx_caretakers.program_id', '=', $programId)
                ->pluck('master_token_fcm.token')
                ->toArray();

            $message = [
                'notification' => $notification,
                'data' => $data,
                'registration_ids' => $tokens,
            ];
        } else {
            $message = [
                'notification' => $notification,
                'data' => $data,
                'to' => $deviceRegistrationToken,
            ];
        }

        // Send the message
        $client = new Client();
        $response = $client->post('https://fcm.googleapis.com/fcm/send', [
            'headers' => [
                'Authorization' => 'key=' . env('GOOGLE_FIREBASE_SERVER_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => $message,
        ]);

        // Handle the response
        $responseBody = json_decode($response->getBody(), true);
        $successCount = $responseBody['success'] ?? 0;
        $failureCount = $responseBody['failure'] ?? 0;
        return ['success' => $successCount, 'failure' => $failureCount];
    }
}
