<?php

namespace SenRouter\Http\Dispatcher;

class Router{
    
    private $routes = [];
    private $currentProcededRoute;
    private $_404 = true;
    

    public function __contruct(){
    
    }
    
    public function mixe($method, $pathPattern, $mixes)
    {
        $this->currentProcededRoute = new Route($method, $pathPattern, $mixes);
        $this->routes[] = $this->currentProcededRoute;
        
        return $this;
    }
    
    
    public function regex($where, $mixes = null){
        
        $routesParams = [];
        if($mixes === null)
        {
            if(is_array($where))
            {
                $routesParams = $where;
            }
            else{
                throw new Exception('Inavlid ....');//TODO fvf
            }
        }
        else{
            
            $routesParams = [
                $where => strval($mixes)
            ];
        }
        
        $this->currentProcededRoute->setRouteParams($routesParams);

        
        return $this;
    }
    
    
    public function run()
    {

        for($i = 0; $i < count($this->routes); $i++)
        {

            $route = $this->routes[$i];
            if($route->matchUrl())
            {
                $route->run();
                $this->_404 = false;
                break;
            }
        }
    }
    
    
    
}