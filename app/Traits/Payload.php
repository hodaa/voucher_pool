<?php

namespace App\Traits;

trait Payload
{
    public function success($code, $data)
    {
        return response()->json([
            'status' => 'OK',
            'code' => $code,
            'data' => $data], $code);

    }

    public function fail($code, $message)
    {
        return response()->json([
            'status' => 'Error',
            'code' => $code,
            'message' => $message], $code);
    }
}
