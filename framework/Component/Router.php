<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 06/11/20
 * Time: 13:01
 */

namespace MegatronFrameWork\Component;


use MegatronFrameWork\Errors\NotFoundException;

class Router
{
    protected $routeCollection = [];

    public function __construct()
    {
        $this->routeCollection[Request::GET] = [];
        $this->routeCollection[Request::POST] = [];
        $this->routeCollection[Request::PUT] = [];
        $this->routeCollection[Request::DELETE] = [];

    }

    public function get($url,$callback = []){
        $this->routeCollection[Request::GET][$url] = $callback;
        return $this;
    }
    public function post($url, $callback = []){
        $this->routeCollection[Request::POST][$url] = $callback;
        return $this;
    }
    public function delete($url,$callback = []){
        $this->routeCollection[Request::DELETE][$url] = $callback;
        return $this;
    }
    public function put($url,$callback = []){
        $this->routeCollection[Request::PUT][$url] = $callback;
        return $this;
    }

    public function resolve(Request $request)
    {
        return $this->match($request, $this->routeCollection);
    }

    protected function match(Request $request, $routerCollection){
        if(!isset($routerCollection[$request->getMethod()])) throw new NotFoundException();
        foreach ($routerCollection[$request->getMethod()] as $route => $callback){
            $route = substr_replace( $route,['/' => ''],0,1);
            $path = substr_replace( $request->getPath(),['/' => ''],0,1);
            if($route === $path) return $callback;
            $routePattern = '#' .  str_replace(["{", "}"], ["(",")"], $route) . '#';
            if(preg_match($routePattern, $path, $matches)){
                if($matches[0] === $path){
                    return $callback;
                }
            }
        }
        throw new NotFoundException();
    }

}