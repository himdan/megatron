<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 26/12/20
 * Time: 13:22
 */

namespace MegatronFrameWork\DI;


class ArgumentResolver
{
    private $resolved = [];

    public function resolve($class){

        $arguments = [];
        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        if(is_null($constructor)){
            $this->resolved[$class] = new $class;
            return $this->resolved[$class];
        }

        foreach ($constructor->getParameters() as $reflectionParameter){
            $name = $reflectionParameter->getType()->getName();
            if(!isset($this->resolved[$name])){
                $this->resolved[$name] = $this->resolve($name);
            }
            $arguments[] = $this->resolved[$name];

        }
        $this->resolved[$class] = (count($arguments))?new $class(...$arguments): new $class;
        return $this->resolved[$class];

    }

    /**
     * @return array
     */
    public function getResolved(): array
    {
        return $this->resolved;
    }


}