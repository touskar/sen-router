<pre>
    
 _________                       __________               __                
 /   _____/ ____   ____           \______   \ ____  __ ___/  |_  ___________ 
 \_____  \_/ __ \ /    \   ______  |       _//  _ \|  |  \   __\/ __ \_  __ \
 /        \  ___/|   |  \ /_____/  |    |   (  <_> )  |  /|  | \  ___/|  | \/
/_______  /\___  >___|  /          |____|_  /\____/|____/ |__|  \___  >__|   
        \/     \/     \/                  \/                        \/    
------------------------------------------------------------------------------ 

</pre>
# Usage

#### .htacess for frontal controller
``` .htaccess
SetEnv FRONTAL_CONTROLER index.php
SetEnv FRONTAL_CONTROLER_SUB_DIR /subdir/ # or / for non subdired project

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
require_once 'HomeController.php';
require_once 'HomeMiddleware.php';

use SenRouter\Http\Dispatcher\Router;

$router = new Router();

$router
    ->get('calcul/{num1}/{num2}', 'HomeController@calcul')
    ->regex([
        'num1' => '\d+',
        'num2' => '\d+'
    ])
    ->middleware([
        'HomeMiddleware@pair'
    ]);

$router->run();

```

#### HomeController

```php
use SenRouter\Http\Response;
class HomeController{
    
    public function calcul($num1, $num2){
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
    
    public function pair($num1, $num2){
        if($num1 % 2 !== 0 || $num2 % 2 !== 0 )
        {
            return 'midlawre';
        }
    }
}

```
