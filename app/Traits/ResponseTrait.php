<?php

namespace App\Traits;

trait ResponseTrait
{
 
    public function response($result = [], $message = "")
    {
        $this->_response =
        [
            'status'        => true,
            'data'          => $result,
            'message'       => $message
        ];

        return response()->json($this->_response, 200);
    }

    public function error($error_message, $error_data = [])
    {
        $this->_response =
        [
            'status'       => false,
            'message'       => $error_message,
        ];
        ! empty($error_data) ? $this->_response['errors'] = $error_data : '';

        return response()->json($this->_response, 200);
    }


}
