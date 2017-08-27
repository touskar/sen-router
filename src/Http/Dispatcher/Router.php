<?php

namespace SenRouter\Http\Dispatcher;

class Router{
    
    private $routes = [];

    private $currentProcededRoute;
    private $_404 = true;
    public $controllerNamespace;
    public $middlewareNamespace;

    private $_404Handler;
    

    public function __contruct($controllerNamespace = '', $middlewareNamespace = ''){
        $this->controllerNamespace = $controllerNamespace;
        $this->middlewareNamespace = $middlewareNamespace;
    }
    
    public function mixe($method, $pathPattern, $mixes)
    {
        $this->currentProcededRoute = new Route($this, $method, $pathPattern, $mixes);
        $this->routes[] = $this->currentProcededRoute;
        
        return $this;
    }
    
    public function middleware($middleware)
    {
        $this->currentProcededRoute->middlewares[] = $middleware;
        return $this;
    }
    
    
    public function regex($where, $mixes = null){
        
        $routesParams = [];
        //verification type params
        if($mixes === null)
        {
            if(is_array($where))
            {
                $routesParams = $where ;
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
        //mettre les params sur le route regex
        
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
                $this->_404 = false;
                $route->prepareRunning();
                $return = $route->processMiddleware();
                
                if(is_string($return) || $return === false)
                {
                    \SenRouter\Http\Response::end($return);
                }
                else{
                    $output = $route->run();
                    \SenRouter\Http\Response::end($output);
                    
                    break;
                }
                
                
            }
        }
        
        if($this->_404)
        {
            if(is_callable($this->_404Handler))
            {
                $route = rtrim($_SERVER['REQUEST_URI'], "/")."/";
                call_user_func_array($this->_404Handler, [
                    $route    
                ]);
            }
            else{
                \SenRouter\Http\Response::withStatus(404);
                echo '404 not found';
            }
        }
    }
    
    public function set404Handler($handler){
        $this->_404Handler = $handler;
    }
    
}