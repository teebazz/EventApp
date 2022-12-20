<?php

namespace App\Traits;

use App\Mail\InviteMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

trait MessageTrait
{
    public function sendMail($attendee)
    {
        // Send mail initemail mailable
        Mail::to($attendee->email)->send(new InviteMail($attendee));
    }

    public function sendSMS($attendee)
    {
        $formatedPhoneNumber = $this->formatPhoneNumber($attendee->phone_number);

        $curl = curl_init();

        $msg = "Hello {$attendee->first_name}, you have been invited to Emmanuel's birthday party. Your entry code is {$attendee->code}";

        $data = array(
            "api_key" => env('TERMII_API'),
            "to" => $formatedPhoneNumber,
            "from" => "N-Alert",
            "sms" => $msg,
            "type" => "plain",
            "channel" => "generic"
        );
        $post_data = json_encode($data);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ng.termii.com/api/sms/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $_response = json_decode($response,true);
        curl_close($curl);
        Log::info($_response);
        return  $_response;
    }


    public function formatPhoneNumber($phoneNumber)
    {
        if(substr($phoneNumber, 0,1) === '0'){
            $phoneNumber = substr_replace($phoneNumber, '234',0,1);
        }elseif (substr($phoneNumber, 0,1) === '+') {
            $phoneNumber = substr_replace($phoneNumber, '',0,1);
        }
        return $phoneNumber;
    }

    public function sendOtp($phoneNumber,$msg)
    {
        
    }
}