<?php

namespace SenRouter\Http;

class Input{

    /**
     * @param $name
     * @param null $default
     * @return null
     */
    public static function get($name, $default = null)
    {
        return (isset($_GET[$name])) ? $_GET[$name] : $default ;
    }

    /**
     * @param $name
     * @param null $default
     * @return null
     */
    public static function post($name, $default = null)
    {
        return (isset($_POST[$name])) ? $_POST[$name] : $default ;
    }
}