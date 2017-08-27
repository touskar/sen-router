<?php

namespace SenRouter\Http\Dispatcher;

class Route{
    
    private $allowedMethod = [];
    private $pathPattern;
    private $currentRoute;
    private $caseSensitive;
    private $routeParams = [];
    private $routeSeparator = "/";
    private $routeWithRegex;
    private $mixes;
    
    public function __construct($method, $pathPattern, $mixes, $caseSensitive = false){
        $this->currentRoute = $_SERVER['REQUEST_URI'];
        $this->pathPattern = $pathPattern;
        $this->setAllowedMethod($method);
        $this->mixes = $mixes;
        
    }
    
    public function matchUrl()
    {
        
        return preg_match($this->routeWithRegex, $this->currentRoute);
    }
    
    public function run(){
        
    }
    
    public function setRouteParams($routeParams)
    {
        $this->routeParams = $routeParams;
        $this->routeWithRegex = $this->pathPattern;
        
        foreach ($this->routeParams as $name => $regex) {
            $this->routeWithRegex =  str_replace('{'.$name.'}', $regex, $this->routeWithRegex);
        }
        
        $this->routeWithRegex = "#".$this->routeWithRegex.'(\?.*)?$#';
    }
    
    
    private function setAllowedMethod($method){
        $methods = [];
        if(is_string($method))
        {
            $methods[] = $method;
        }
        else if(is_array($method))
        {
            $methods = $methods;
        }
        
        foreach ($methods as $value) {
            if(in_array($value, \SenRouter\Http\Request::getAllHttpMethod()))
            {
                $this->allowedMethod[] = strtolower($value);
            }
        }
    }
    
    
}