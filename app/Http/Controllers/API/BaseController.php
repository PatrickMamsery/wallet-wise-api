<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class BaseController extends Controller
{
    public function sendResponse($result, $message = '')
    {
        return ($result->additional(['status' => 'success', 'message' => Config::get('customMessages.' . $message), 'statusCode' => 200]));
    }

    public function sendError($error, $errorMessages = [], $error_status_code = 404)
    {
        $response = [
            'status' => 'error',
            'message' => Config::get('customMessages.' . $error),
            'statusCode' => $error_status_code,
        ];


        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $error_status_code);
    }
}
