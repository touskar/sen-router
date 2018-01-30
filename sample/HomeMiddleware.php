<?php 

use SenRouter\Http\Response;

class HomeMiddleware{
    
    public function isOdd($num1, $num2){
        if($num1 % 2 !== 0 || $num2 % 2 !== 0 )
        {
            Response::withStatus(422);
            return Response::withJson([
                'success' => -1,
                'error' => 'params should be odd number'
            ]);
        }

        return true;
    }
}