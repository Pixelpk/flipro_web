<?php
namespace App\Libs\Firebase;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Firebase
{

    private $URL = "https://fcm.googleapis.com/fcm/send";
    private $key;
    private $title;
    private $body;
    private $priority = 'high';
    private $toTokens;
    private $data = [];
    private $image;
    private $headers;

    public function __construct($headers = [
        "apns-push-type" => "background",
        "apns-priority" => "5",
        "apns-topic" => "io.flutter.plugins.firebase.messaging",
    ]) {
        $this->key = config('app.fcmkey');
        $this->headers = $headers;
    }

    private function validate()
    {
        $validator = Validator::make([
            'title' => $this->title,
            'body' => $this->body,
            'toTokens' => $this->toTokens,
        ], [
            'title' => 'required',
            'body' => 'required',
            'toTokens' => 'required',
        ], [
            'title.*' => 'Title not set or invalid please use setTitle() method to set valid title',
            'body.*' => 'Body not set or invalid please use setBody() method to set valid body',
            'toTokens.*' => 'TotTokens not set or invalid please use setToTokens() method to set valid toTokens',
        ]);
        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

    }

    private function data()
    {
        return [
            'to' => $this->toTokens,
            'priority' => $this->priority,
            'notification' => [
                'title' => $this->title,
                'body' => $this->body,
            ],
            'data' => $this->data,
            'apns' => [
                'payload' => [
                    'aps' => [
                        'contentAvailable' => true,
                    ],
                ],
                'fcm_options' => [
                    'image' => $this->image,
                ],
                'headers' => $this->headers,
            ],
        ];
    }

    public function setToTokens($tokens){
        $this->toTokens = $tokens;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function setBody($body){
        $this->body = $body;
    }

    public function setData($data){
        $this->data = $data;
    }

    public function send()
    {
        $this->validate();
        $crl = curl_init();
        $headr = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: key=' . $this->key;
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($crl, CURLOPT_URL, $this->URL);
        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, json_encode($this->data(), JSON_FORCE_OBJECT));
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        $rest = curl_exec($crl);
        if ($rest == false) {
            $result_noti = 0;
        } else {
            $result_noti = 1;
        }
        curl_close($crl);
        Log::debug([
            'token' => $this->toTokens,
            'response' => $rest
        ]);
        return $rest;
    }

    public function batchSend($tokens, $data, $title, $body)
    {
        foreach($tokens as $token){
            $this->setTitle($title);
            $this->setBody($body);
            $this->setData($data);
            $this->setToTokens($token['token']);
            $this->send();
        }
    }
}
