<?php  
namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseTrait
{

    /**
     * Success response
     * 
     * @param array|object $data
     * @param string $message
     * 
     * @return JsonResponse
     */
    public function responseSuccess($data,$message='Successful Operation'): JsonResponse
    {
        return response()->json([
            'status'=>true,
            'message'=>$message,
            'data'=>[],
            'errors'=>null,
        ]);
    }

    /**
     * Error response
     * 
     * @param array|object $data
     * @param string $message
     * 
     * @return JsonResponse
     */
    public function responseError($errors,$message='Data is Invalid'): JsonResponse
    {
        return response()->json([
            'status'=>false,
            'message'=>$message,
            'data'=>[],
            'errors'=>$errors,
        ], Response::HTTP_BAD_REQUEST);
    }

}