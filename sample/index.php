<?php



error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../vendor/autoload.php');
use SenRouter\Http\Dispatcher\Router;
use SenRouter\Http\Response;
use SenRouter\Http\Input;

require_once 'HomeController.php';
require_once 'HomeMiddleware.php';

$router = new Router([
    'controllerNamespace' => '',
    'middlewareNamespace' => '',
    'subDirectory' => getenv('FRONTAL_CONTROLER_SUB_DIR')
]);

/**
 * uncomment this to handle 404
 */
//$router->set404Handler(function($route){
//    echo 'no route mached'.$route;
//});

$router
    ->mixe('get','/calcul1/{num1}/{num2}', function ($num1, $num2){

         return Response::withXml([
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
            Response::withStatus(422);
            return Response::withJson([
                'success' => -1,
                'error' => 'params should be odd number'
            ]);
        }
        
        return true;
        
    })
    ->separator("/");

$router
    ->mixe('get','/calcul2-{num1}-{num2}', 'HomeController@calcul')
    ->regex([
        'num1' => '\d+',
        'num2' => '\d+'
    ])
    ->middleware(['HomeMiddleware@pair']) //->middleware('HomeMiddleware@pair')
    ->separator("-");


$router->run();


// name:{regex}