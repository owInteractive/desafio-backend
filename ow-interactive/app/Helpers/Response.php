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

    static function notFound($data)
    {
        return self::response($data, 404);
    }

    static function serverError()
    {
        return self::response(['message' => "Ocorreu um erro, tente novamente mais tarde."], 500);
    }

    static function badRequest($data)
    {
        return self::response($data, 400);
    }

    static function unauthorized($data = ['message' => 'Acesso não autorizado.'])
    {
        return self::response($data, 401);
    }

    static function forbidden($data = ['message' => 'Ação não permitida.'])
    {
        return self::response($data, 403);
    }

    static function stream($makeFile, $headers = [])
    {
        return response()->stream($makeFile, 200, $headers);
    }

    private static function response($data, $status)
    {
        return response()->json($data, $status);
    }
}
