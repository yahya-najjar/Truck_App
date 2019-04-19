<?php

namespace App\Http\Responses;

class Responses {
    /**
     * @param array $content
     * @return \Illuminate\Http\JsonResponse
     */
    public static function respondSuccess($content = [],$paginator = null){
        return response()->json([
            'result' => 'success',
            'content' => $content,
            'paginator' => $paginator,
            'error_des' => '',
            'error_code' => 0,
            'date' =>date('Y-m-d')
        ],200);
    }

    public static function respondError($message){
        return response()->json([
            'result' => 'error',
            'content' => null,
            'error_des' => $message,
            'error_code' => 1,
            'date' =>date('Y-m-d')
        ],400);
    }

    public static function respondOut($message){
        return response()->json([
            'result' => 'error',
            'content' => null,
            'error_des' => $message,
            'error_code' => -1,
            'date' =>date('Y-m-d')
        ]);
    }

    public static function respondMessage($message){
        return response()->json([
            'result' => 'success',
            'content' => [],
            'error_des' => $message,
            'error_code' => 0,
            'date' =>date('Y-m-d')
        ]);
    }
}