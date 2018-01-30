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
}