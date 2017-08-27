<?php

error_reporting(E_ALL);

require_once('vendor/autoload.php');
use SenRouter\Http\Dispatcher\Router;


$controllerDirectory = __DIR__.'/sample/';

$router = new Router();

$router
    ->mixe('get','/calcul/{num1}/{num2}', function ($num1, $num2){
         echo $num1 + $num2;
    })
    ->regex([
        'num1' => '\d+',
        'num2' => '\d+'
    ]);

//$router
//    ->mixe(['get'],'/calcul/num1:(\d+){1,4}/num2:(\d+){1,4}', 'HomeController@home');
    

$router->run();


// name:{regex}