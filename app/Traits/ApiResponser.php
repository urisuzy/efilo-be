<?php

namespace App\Traits;

trait ApiResponser
{
    public function successReponse($result)
    {
        return response()->json([
            'code' => 200,
            'success' => true,
            'result' => $result
        ], 200);
    }

    public function errorResponse($message, $code = 400)
    {
        return response()->json([
            'code' => $code,
            'success' => false,
            'message' => $message
        ], $code);
    }
}
