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
    'subDirectory' => getenv('FRONTAL_CONTROLER_SUB_DIR')
]);


$router
    ->get('/calcul/{num1}/{num2}', 'HomeController@calcul')
    ->regex([
        'num1' => '\d+',
        'num2' => '\d+'
    ])
    ->middleware([
        'HomeMiddleware@pair'
    ]);

$router->run();


// name:{regex}