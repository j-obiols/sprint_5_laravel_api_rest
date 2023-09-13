<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class GeneralJsonException extends Exception
{
    public function report(){}
    
    /** 
     * render the exception as an HTTP response
     * 
     *  @param \Illuminate\Http\Request $request 
     */
    public function render($request){

        return new JsonResponse([
            'errors' => [
                'message' => $this -> getMessage(),
            ]
        ], $this->code);
        
    }
}
