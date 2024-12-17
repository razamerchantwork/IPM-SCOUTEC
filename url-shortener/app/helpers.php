<?php

if (! function_exists('successResponse')) {
    function successResponse($data = [], $message = '',  $code = 200)
    {

        $response = [
            'success' => true,
            'status_code' => $code,
            'message' => [$message],
            'data' => $data
        ];
        return response()->json($response, $code);
    }
}



if (! function_exists('errorResponse')) {
    /**
     * @param $error
     * @param string $message
     * @param int $status_code
     * @return \Illuminate\Http\JsonResponse
     */
    function errorResponse($message, int $code = 400, $data = [])
    {

        $code = $code == 0 ? 400 : $code;
        $response = [
            'success' => false,
            'status' => $code,
            'message' => $message,
            'data' => $data
        ];
        if ($code == 422) {
            $response['data'] = $data;
        }

        $code = is_int($code) && $code != 0 ? $code : 500;

        return response()->json($response, $code);
    }
}


