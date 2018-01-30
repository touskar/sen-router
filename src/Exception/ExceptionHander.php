<?php
/**
 * Created by PhpStorm.
 * User: moussandour
 * Date: 30/01/2018
 * Time: 10:03
 */

namespace SenRouter\Exception;

class ExceptionHander
{
    public static function handle(){
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }


    public static function exceptionErrorHandler($errno, $errstr, $errfile, $errline ){
        throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
    }

    public static function errorHandler(){
        //self::handle();
        //throw new \ErrorException();
    }

}