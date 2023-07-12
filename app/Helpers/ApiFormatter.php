<?php
namespace App\Helpers;

class ApiFormatter {
    protected static $responses = [
        'code' => NULL,
        'message' => NULL,
        'data' => NULL,
    ];

    public static function createApi($code = NULL, $message = NULL, $data = NULL) {
        self::$responses['code'] = $code;
        self::$responses['message'] = $message;
        self::$responses['data'] = $data;
        return response()->json(self::$responses, self::$responses['code']);
    }
}