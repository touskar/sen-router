<?php

namespace SenRouter\Http\Dispatcher;

use Exception;
use SenRouter\Exception\ExceptionHander;
use SenRouter\Http\Response;

class Router{

    /**
     * @var array
     */
    private $routes = [];

    /**
     * @var Route
     */
    private $currentProcededRoute;

    /**
     * @var bool
     */
    private $_404 = true;

    /**
     * @var string
     */
    public $controllerNamespace;

    /**
     * @var string
     */
    public $middlewareNamespace;

    /**
     * @var string
     */
    public $subDirectory;

    /**
     * @var callable
     */
    private $_404Handler;
    

    public function __construct($params){
        $defaultOption = [
            'controllerNamespace' => '',
            'middlewareNamespace' => '',
            'subDirectory' => ''
        ];

        $option = array_merge($defaultOption, $params);

        $this->controllerNamespace = $option['controllerNamespace'];
        $this->middlewareNamespace = $option['middlewareNamespace'];
        $this->subDirectory = rtrim($option['subDirectory'], "/");

        $this->setRequestUri();


    }

    private function setRequestUri(){
        $_SERVER['REQUEST_URI'] = str_replace($this->subDirectory, '', $_SERVER['REQUEST_URI']);
    }

    /**
     * @param $method string|array
     * @param $pathPattern string
     * @param $mixes string|callable
     * @return $this
     */
    public function mixe($method, $pathPattern, $mixes)
    {
        $this->currentProcededRoute = new Route($this, $method, $pathPattern, $mixes);
        $this->routes[] = $this->currentProcededRoute;
        
        return $this;
    }

    /**
     * @param $middleware  string|string[]|callable|callable[]
     * @return $this
     */
    public function middleware($middleware)
    {
        $middlewares = is_array($middleware) ? $middleware : [$middleware];
        
        foreach($middlewares as $md)
        {
            $this->currentProcededRoute->middlewares[] = $md;
        }
        
        return $this;
    }

    /**
     * @param string $sep
     * @return $this
     */
    public function separator($sep = "/")
    {
        $this->currentProcededRoute->setRouteSeparator($sep);
        return $this;
    }


    /**
     * @param $where array|string
     * @param $mixes string|null
     * @return $this
     * @throws Exception
     */
    public function regex($where, $mixes = null){
        
        $routesParams = null;
        if($mixes === null)
        {
            if(is_array($where))
            {
                $routesParams = $where ;
            }
            else{
                ExceptionHander::handle();
                throw new \InvalidArgumentException('Invalid argument passed to regex');
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


    /**
     *
     */
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
                    Response::end($return);
                }
                else{
                    $output = $route->run();
                    Response::end($output);
                    break;
                }
                
                
            }
        }
        
        if($this->_404)
        {
            if(is_callable($this->_404Handler))
            {
                $route = $_SERVER['REQUEST_URI'];
                call_user_func_array($this->_404Handler, [
                    $route    
                ]);
            }
            else{
                Response::withStatus(404);
                echo '404 not found';
            }
        }
    }

    /**
     * @param $handler
     */
    public function set404Handler($handler){
        $this->_404Handler = $handler;
    }
    
}
