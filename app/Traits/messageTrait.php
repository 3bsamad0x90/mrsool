<?php

namespace App\Traits;
use Illuminate\Http\Response;

trait  messageTrait{

    public function successfully($msg, $data)
    {
        return response()->json([
            'status' => true,
            'message' => $msg,
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function failed($msg, $errors = [])
    {
        return response()->json([
            'status' => false,
            'message' => $msg,
            'errors' => $errors
        ], Response::HTTP_NOT_FOUND);
    }

}

?>
