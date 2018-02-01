<?php

require_once('../vendor/autoload.php');
require_once 'HomeController.php';
require_once 'HomeMiddleware.php';

use SenRouter\Http\Dispatcher\Router;
use SenRouter\Http\Dispatcher\R;
use SenRouter\Http\Response;

$router = new Router();

/**
 * call from $router Object
 **/
$router
    ->get('hello/{name}', function ($name) {
        return "Hello $name";
    });

$router
    ->get('hello.{name}', function ($name) {
        return "Hello $name";
    })
    ->separator(".");

/**
 * Call from static method
 **/
R::get('calcul.{num1}.{num2}', function ($num1, $num2) {
    return Response::withJson([
        'result' => $num1 + $num2
    ]);
})
    ->regex([
        'num1' => '\d+',
        'num2' => '\d+'
    ])
    ->middleware([
        'HomeMiddleware@isOdd',
        function ($num1, $num2) {
            if ($num1 == $num2) {
                return false;
            }
        }
    ])
    ->separator(".");

$router->run();
//or
R::run();