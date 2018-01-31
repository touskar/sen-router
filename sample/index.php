<?php



require_once('../vendor/autoload.php');
require_once 'HomeController.php';
require_once 'HomeMiddleware.php';

use SenRouter\Http\Dispatcher\Router;

$router = new Router();


$router
    ->get('calcul/{num1}/{num2}', 'HomeController@sum')
    ->regex([
        'num1' => '\d+',
        'num2' => '\d+'
    ])
    ->middleware([
        'HomeMiddleware@isOdd'
    ]);

$router
    ->post('calcul.{num1}.{num2}', 'HomeController@sum')
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