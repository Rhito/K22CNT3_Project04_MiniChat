<?php

namespace App\Traits;

trait HttpResponses {
    protected function success($data = '', $message = 'Success', $code = 200) {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error($message = 'Something went wrong', $data = '', $code = 500) {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
