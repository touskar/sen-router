<?php 

use SenRouter\Http\Response;

class HomeMiddleware{
    
    public function pair($num1, $num2){
        if($num1 % 2 !== 0 || $num2 % 2 !== 0 )
        {
            return 'midlawre';
        }
    }
}