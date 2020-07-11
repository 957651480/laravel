<?php
if (! function_exists('api_response')) {

    /**
     * @param int $code
     * @param string $msg
     * @param array $data
     * @return \App\Http\Response\ApiResponse
     */
    function api_response(array $response=[])
    {
        $factory = app(\App\Http\Response\ApiResponse::class);
        if (func_num_args() === 0) {
            return $factory;
        }
        return $factory->json($response);
    }
}
