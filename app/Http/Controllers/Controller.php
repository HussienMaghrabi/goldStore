<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    # -------------------------------------------------
    public function uploadBase64($base64, $path, $extension = 'jpeg')
    {
        $fileBaseContent = base64_decode($base64);
        $fileName = str_random(10).'_'.time().'.'.$extension;
        $file = $path.'/'.$fileName;
        Storage::disk('public')->put('uploads/'.$file, $fileBaseContent);
        return 'uploads/' . $file;
    }

    public function uploadFile($file, $path)
    {
        $filename = Storage::disk('public')->put('uploads/'.$path, $file);
        return $filename;
    }

    # -------------------------------------------------
    public function broadCastNotification($title, $body, $id = null)
    {
        $auth_key = "AAAA3wXWDEA:APA91bGMvTDY0ky9LFdI73vq-0c5-yKX_OMG1BslfAuQVzBJ6U2GJPhqqr8BUdgn3NjCle7WiyDw8mgXemI0RfQ2-KbBdbdwJHdozUvwuS2zJTNtyyeneZitrDiGPejIaSemyqJoPreE";
        $topic   = "/topics/gold_store";
        $data = [
            'body'         => $body,
            'title'        => $title,
            'id'        => $id,
            'click_action' => 'com.ValuxApps.AnnakDriver.Splash',
            'icon'         => 'myicon',
            'banner'         => '1',
            'sound'        => 'mySound',
            "priority"      => "high",
        ];

        $notification = [
            'body'         => $body,
            'title'        => $title,
            'id'        => $id,
            'click_action' => 'com.ValuxApps.annak.Splash',
            'data' => $data,
            'icon'         => 'myicon',
            'banner'         => '1',
            'sound'        => 'mySound',
            "priority"      => "high",
        ];

        $fields = json_encode([
            'to'           => $topic,
            'notification'    => $notification,
            'data'            => $data,
        ]);

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, ['Authorization: key=' . $auth_key, 'Content-Type: application/json']);
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec ( $ch );
        curl_close ( $ch );
    }

    # -------------------------------------------------
    public function pushNotification($notification)
    {
        $auth_key = "AAAA3wXWDEA:APA91bGMvTDY0ky9LFdI73vq-0c5-yKX_OMG1BslfAuQVzBJ6U2GJPhqqr8BUdgn3NjCle7WiyDw8mgXemI0RfQ2-KbBdbdwJHdozUvwuS2zJTNtyyeneZitrDiGPejIaSemyqJoPreE";

        $device_token = $notification['fcm_token'];
//        if($device_token == NULL){
//            return 0;
//        }

        $data = [
            'body' 	=> $notification['body'],
            'title'	=> $notification['title'],
            'id'	=> $notification['id'],
            'click_action' => 'com.ValuxApps.AnnakDriver.Detail',
            'icon'	=> 'myicon',
            'banner'         => '1',
            'sound'        => 'mySound',
            "priority"      => "high",
        ];

        $notification = [
            'body' 	=> $notification['body'],
            'title'	=> $notification['title'],
            'id'	=> $notification['id'],
            'click_action' => 'com.ValuxApps.AnnakDriver.Detail',
            'data' => $data,
            'icon'	=> 'myicon',
            'banner'         => '1',
            'sound'        => 'mySound',
            "priority"      => "high",
        ];

        $fields             = json_encode([
            'registration_ids'  => $device_token,
            'notification'    => $notification,
            'data'            => $data,
        ]);

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, ['Authorization: key=' . $auth_key, 'Content-Type: application/json']);
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec ( $ch );
        curl_close ( $ch );
    }
}
