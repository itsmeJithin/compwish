<?php
/**
 * User: jithinvijayan
 * Date: 27/02/19
 * Time: 3:01 PM
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @param $result
     * @param $message
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    /**
     * @param $error
     * @param array $errorMessages
     * @return mixed
     */
    public function sendJsonError($error, $errorMessages = [])
    {
        $response = [
            "success" => false,
            "error" => $error
        ];
        if (!empty($errorMessages)) {
            $response["messages"] = $errorMessages;
        }
        return response()->json($response, 200);
    }


}