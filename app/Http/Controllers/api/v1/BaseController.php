<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Success response method
     * 
     * @param $result
     * @param $message
     * @return JsonResponse
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];

        return response()->json($response, 200);
    }

    /**
     * Return error response from
     *
     * @param  $error
     * @param  $errorMessage
     * @param int $statusCode
     * @return JsonResponse
     */
    public function sendError($error, $errorMessage = [], $statusCode = 404)
    {
        $response = [
            'success' => false,
            'message' => $error
        ];

        !empty($errorMessage) ? $response['data'] = $errorMessage : null;

        return response()->json($response, $statusCode);
    }
}