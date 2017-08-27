<?php

namespace SenRouter\Http;

class Request{
    
    public function __contruct(){
        
    }
    
    public static function getRequestMethod(){
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    
    public static function isGetMethod(){
        return self::getRequestMethod() === 'get';
    }
    
    public static function isPostMethod(){
        return self::getRequestMethod() === 'post';
    }
    
    public static function getAllHttpMethod(){
        return [
            'get',
            'post',
            'put',
            'patch',
            'delete',
            'update'
        ];
    }
    
    private static $instance = null;
    
    
}