<?php


namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{

    public function handleResponse($result, $msg)
    {
        $res = [
            'success' => true,
            'data'    => $result,
            'message' => $msg,
        ];
        return response()->json($res, 200);
    }

    public function handleError($error, $errorMsg = [], $code = 404)
    {
        $res = [
            'success' => false,
            'message' => $error,
        ];
        if (!empty($errorMsg)) {
            $res['data'] = $errorMsg;
        }
        return response()->json($res, $code);
    }

    public function throwUnAuthorizedMessage()
    {
        $res = [
            'success' => false,
            'message' => 'Your are not authorized to perform this action',
        ];

        return response()->json($res, 401);
    }
}
