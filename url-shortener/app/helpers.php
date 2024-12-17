<?php

if (! function_exists('successResponse')) {
    function successResponse($data = [], $message = '', $paginate = FALSE, $code = 200)
    {
        if ($paginate == TRUE && is_object($data)) {
            $data = paginate($data);
        }

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

if (! function_exists('paginate')) {
    function paginate($data = [])
    {

        $paginationArray = NULL;
        if ($data != NULL) {
            $paginationArray = array('list' => $data->items(), 'pagination' => []);
            $paginationArray['pagination']['total'] = $data->total();
            $paginationArray['pagination']['current'] = $data->currentPage();
            $paginationArray['pagination']['first'] = 1;
            $paginationArray['pagination']['last'] = $data->lastPage();
            if ($data->hasMorePages()) {
                if ($data->currentPage() == 1) {
                    $paginationArray['pagination']['previous'] = 0;
                } else {
                    $paginationArray['pagination']['previous'] = $data->currentPage() - 1;
                }
                $paginationArray['pagination']['next'] = $data->currentPage() + 1;
            } else {
                $paginationArray['pagination']['previous'] = $data->currentPage() - 1;
                $paginationArray['pagination']['next'] = $data->lastPage();
            }
            if ($data->lastPage() > 1) {
                $paginationArray['pagination']['pages'] = range(1, $data->lastPage());
            } else {
                $paginationArray['pagination']['pages'] = [1];
            }
            $paginationArray['pagination']['from'] = $data->firstItem();
            $paginationArray['pagination']['to'] = $data->lastItem();

            return $paginationArray;
        }
        return $paginationArray;
    }
}
