<?php



require_once('../vendor/autoload.php');
require_once 'HomeController.php';
require_once 'HomeMiddleware.php';

use SenRouter\Http\Dispatcher\R;

R::get('calcul/{num1}/{num2}', 'HomeController@sum')
->regex([
    'num1' => '\d+',
    'num2' => '\d+'
])
->middleware([
    'HomeMiddleware@isOdd'
]);


R::post('calcul.{num1}.{num2}', 'HomeController@sum')
->regex([
    'num1' => '\d+',
    'num2' => '\d+'
])
->middleware([
    'HomeMiddleware@isOdd'
])
->separator(".");

R::run();


// name:{regex}