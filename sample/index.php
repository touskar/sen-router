<?php

require_once('../vendor/autoload.php');
require_once 'HomeController.php';
require_once 'HomeMiddleware.php';

use SenRouter\Http\Dispatcher\Router;

$router = new Router();

$router
    ->get('hello/{name}', function($name){
        return "Hello $name";
    });

$router
    ->get('calcul/{num1}/{num2}', 'HomeController@sum')
    ->regex([
        'num1' => '\d+',
        'num2' => '\d+'
    ])
    ->middleware([
        'HomeMiddleware@isOdd'
    ])
    ->separator(".");

$router->post('calcul.{num1}.{num2}', function ($num1, $num2){
    return Response::withJson([
        'result' => $num1 + $num2
    ]);
})
    ->regex([
        'num1' => '\d+',
        'num2' => '\d+'
    ])
    ->middleware([
        'HomeMiddleware@isOdd'
    ])
    ->separator(".");

$router->run();


// name:{regex}