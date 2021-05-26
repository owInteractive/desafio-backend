<?php

namespace App\Http\Controllers;

use Response;

/**
 * @SWG\Swagger(
 *   basePath="/api/",
 *   @SWG\Info(
 *     title="AppBaseController"
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return Response::json([
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ]);
    }

    public function sendError($error, $code = 404)
    {
        return Response::json([
            'success' => false,
            'message' => $error
        ], $code);
    }

    public function sendSuccess($message)
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], 200);
    }
}
