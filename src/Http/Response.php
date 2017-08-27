<?php

namespace SenRouter\Http;

class Response{

    /**
     * @param $code
     */
    public static function withStatus($code){
         http_response_code($code);
    }

    /**
     * @param $data
     * @return string
     */
    public static function withJson($data){
        Response::withHeader('Content-Type', 'application/json');
        
        return json_encode($data, JSON_PRETTY_PRINT
                                |JSON_HEX_QUOT|JSON_HEX_APOS);
    }

    /**
     * @param $name
     * @param $value
     */
    public static function withHeader($name, $value){
        header("$name: $value");
    }

    /**
     * @param $value
     */
    public static function end($value){
        die($value);
    }
}