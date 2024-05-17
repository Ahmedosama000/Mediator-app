<?php

namespace App\Http\traits;

trait ApiTrait {

    public function SuccessMessage(string $message = "",int $code)
    {
        return response()->json(
            [
                'message'=>$message,
                'errors'=>(object)[],
                'data'=>(object)[],
            ],
            $code
        );
    }

    public function ErrorMessage(Array $errors , string $message = "",int $code)
    {
        return response()->json(
            [
                'message'=>$message,
                'errors'=> $errors,
                'data'=>(object)[],
            ],
            $code
        );
    }

    public function Data(Array $data,string $message = "",int $code )
    {
        return response()->json(
            [
                'message'=>$message,
                'errors'=>(object)[],
                'data'=>$data,
            ],
            $code
        );
    }
}