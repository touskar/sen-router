<?php

namespace SenRouter\Http;

class Input{
    
    public static function get($name, $default = null)
    {
        return (isset($_GET[$name])) ? $_GET[$name] : $default ;
    }
    
    public static function post($name, $default = null)
    {
        return (isset($_POST[$name])) ? $_POST[$name] : $default ;
    }
}