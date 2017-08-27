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
SetEnv FRONTAL_CONTROLER_SUB_DIR /public/my_github/sen-router/sample/

<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)/$ /$1 [L,R=301]

    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ %{ENV:FRONTAL_CONTROLER} [L]

    RewriteCond %{HTTP:Authorization} ^(.*)
    RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]
</IfModule>


```