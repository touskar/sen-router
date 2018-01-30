<pre>
    
 _________                       __________               __                
 /   _____/ ____   ____           \______   \ ____  __ ___/  |_  ___________ 
 \_____  \_/ __ \ /    \   ______  |       _//  _ \|  |  \   __\/ __ \_  __ \
 /        \  ___/|   |  \ /_____/  |    |   (  <_> )  |  /|  | \  ___/|  | \/
/_______  /\___  >___|  /          |____|_  /\____/|____/ |__|  \___  >__|   
        \/     \/     \/                  \/                        \/    
------------------------------------------------------------------------------ 

</pre>
## Usage

### .htacess for frontal controller
``` 
SetEnv FRONTAL_CONTROLER index.php
SetEnv FRONTAL_CONTROLER_SUB_DIR /path/project/ #replace by subdir or / for non subdir project

<IfModule mod_rewrite.c>
    Options -MultiViews
    RewriteEngine On

    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule . %{ENV:FRONTAL_CONTROLER} [L]

    RewriteCond %{HTTP:Authorization} ^(.*)
    RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]
</IfModule>
```


### index.php

```
require_once('../vendor/autoload.php');
require_once 'HomeController.php';
require_once 'HomeMiddleware.php';

use SenRouter\Http\Dispatcher\Router;
use SenRouter\Http\Response;
use SenRouter\Http\Input;


$router = new Router([
    'controllerNamespace' => '',
    'middlewareNamespace' => '',
    'subDirectory' => getenv('FRONTAL_CONTROLER_SUB_DIR')
]);

$router->set404Handler(function($route){
    echo 'no route mached'.$route;
});

$router
    ->mixe('get','/calcul1-{num1}-{num2}', function ($num1, $num2){
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
    ->separator("-");
    
 $router
    ->mixe('get','/calcul2-{num1}-{num2}', 'HomeController@calcul')
    ->regex([
        'num1' => '\d+',
        'num2' => '\d+'
    ])
    ->middleware(['HomeMiddleware@pair'])
    ->separator("-");
    
$router->run();
```

### HomeController

```
use SenRouter\Http\Response;
class HomeController{
    
    public function calcul($num1, $num2){
        return Response::withJson([
            'result' => $num1 + $num2
        ]);
    }
}

```

### HomeMiddleware

```
use SenRouter\Http\Response;
class HomeMiddleware{
    
    public function pair($num1, $num2){
        if($num1 % 2 !== 0 || $num2 % 2 !== 0 )
        {
            return 'midlawre';
        }
    }
}

```
