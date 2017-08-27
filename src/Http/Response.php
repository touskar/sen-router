<?php

namespace SenRouter\Http;

class Response{
    
    public static function withStatus($code){
         http_response_code($code);
    }
    
    public static function withJson($data){
        Response::withHeader('Content-Type', 'application/json');
        
        return json_encode($data, JSON_PRETTY_PRINT
                                |JSON_HEX_QUOT|JSON_HEX_APOS);
    }
    

    public static function withHeader($name, $value){
        header("$name: $value");
    }
    
    public static function end($value){
        die($value);
    }
}