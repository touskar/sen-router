<?php


error_reporting(E_ALL);

require_once('vendor/autoload.php');
use SenRouter\Http\Dispatcher\Router;
use SenRouter\Http\Response;

require_once 'sample/HomeController.php';
require_once 'sample/HomeMiddleware.php';

$router = new Router();
$router->set404Handler(function($route){
    echo 'no '.$route;
});

$router
    ->mixe('get','/calcul1/{num1}/{num2}', function ($num1, $num2){
         return Response::withJson([
             'success' => 1,
             'result' => $num1 + $num2,
        ]);
    })
    ->regex([
        'num1' => '\d+',
        'num2' => '\d+'
    ])
    ->middleware(function($num1, $num2){
        if($num1 % 2 !== 0 || $num2 % 2 !== 0 )
        {
            Response::withStatus(415);
            return Response::withJson([
                'success' => -1,
                'error' => 'params should be odd number'
            ]);
        }
        
        return true;
        
    });

$router
    ->mixe('get','/calcul2/{num1}/{num2}', 'HomeController@home')
    ->middleware('HomeMiddleware@pair');
    ;
    

$router->run();


// name:{regex}