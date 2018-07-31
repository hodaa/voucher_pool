<?php

namespace App\Traits;

use App\Enums\StatusCode;

trait Payload
{
    public function success($code, $data)
    {

        header('Content-Type: application/json');

        $message = StatusCode::$status[$code];

        header("HTTP/1.1 $code $message");
        $response = ['status' => 'OK', 'code' => $code, 'data' => $data];
        return  json_encode($response);
    }

    public function fail($code, $message, $data=null)
    {
        header('Content-Type: application/json');
        $codeMessage = StatusCode::$status[$code];
        header("HTTP/1.1 $code $codeMessage");
        $response = ['status' => 'Error', 'code' => $code, 'message' => $message];

        if($data!==null) $response['data']= $data  ;

        return json_encode($response);
    }
}
