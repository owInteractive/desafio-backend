<?php

namespace App\Helpers;

class Response
{

    static function created($data)
    {
        return self::response($data, 201);
    }

    static function success($data)
    {
        return self::response($data, 200);
    }

    static function badRequest($data)
    {
        return self::response($data, 400);
    }

    private static function response($data, $status)
    {
        return response()->json($data, $status);
    }
}
