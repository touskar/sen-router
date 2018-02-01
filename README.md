
<pre>
    
 _________                       __________               __                
 /   _____/ ____   ____           \______   \ ____  __ ___/  |_  ___________ 
 \_____  \_/ __ \ /    \   ______  |       _//  _ \|  |  \   __\/ __ \_  __ \
 /        \  ___/|   |  \ /_____/  |    |   (  <_> )  |  /|  | \  ___/|  | \/
/_______  /\___  >___|  /          |____|_  /\____/|____/ |__|  \___  >__|   
        \/     \/     \/                  \/                        \/    
------------------------------------------------------------------------------ 

</pre>

#Info
[Click to see SenRouter in Packagist](https://packagist.org/packages/touskar/sen-router)

# Install
composer require touskar/sen-router
# Usage

#### .htacess for frontal controller
``` .htaccess
SetEnv FRONTAL_CONTROLER index.php
SetEnv FRONTAL_CONTROLER_SUB_DIR /web/root/ # or / for non subdired project

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


#### index.php 

```php
require_once('../vendor/autoload.php');

use SenRouter\Http\Dispatcher\Router;
use SenRouter\Http\Dispatcher\R;

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
```

#### HomeController

```php
use SenRouter\Http\Response;
class HomeController{
    
    public function sum($num1, $num2){
        return Response::withJson([
            'result' => $num1 + $num2
        ]);
    }
}

```

#### HomeMiddleware

```php
use SenRouter\Http\Response;
class HomeMiddleware{
    
     /**
      * Return strict value False or no empty string to block
      * returned value will be send as request response
      */
    public function isOdd($num1, $num2){
        if($num1 % 2 !== 0 || $num2 % 2 !== 0 )
        {
            return false;// return 'some_string';
        }
    }
}

```

