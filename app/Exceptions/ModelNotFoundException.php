<?php

namespace App\Exceptions;

class ModelNotFoundException extends \Exception
{
    /**
     * InvalidCredentialsException constructor.
     */

    public function render($request)
    {
        return response()->json(["message" => __api('Invalid credintials')]);
    }
}
