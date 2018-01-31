<?php 

use SenRouter\Http\Response;

class HomeController{
    
    public function sum($num1, $num2){
        return Response::withJson([
            'result' => $num1 + $num2
        ]);
    }


}