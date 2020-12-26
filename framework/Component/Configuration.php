<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 26/12/20
 * Time: 20:14
 */

namespace MegatronFrameWork\Component;


final class Configuration
{
    protected $services = [];
    protected $parameters = [];

    public  function load($parameters=[], $services = []){


        $this->parameters = $parameters;
        $this->services = $services;
        return $this;

    }

    public function getParameter($name){
        if(isset($this->parameters[$name])) return $this->parameters[$name];
        throw new \Exception(sprintf('Parameter with name %s not found', $name));
    }

    public function getArgument($caller, $key){
        if(isset($this->services[$caller])){
            if(isset($this->services[$caller][$key])) return $this->services[$caller][$key];
        }

        throw new \Exception(sprintf('Argument %d for %s not found', $key, $caller));
    }
}