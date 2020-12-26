<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 26/12/20
 * Time: 13:22
 */

namespace MegatronFrameWork\DI;

use MegatronFrameWork\Component\Configuration;

/**
 * Class ArgumentResolver
 * @package MegatronFrameWork\DI
 * @internal
 */
class ArgumentResolver
{
    private $resolved = [];
    protected $parameters = [];
    /**
     * @var Configuration $configuration
     */
    protected $configuration;

    /**
     * ArgumentResolver constructor.
     * @param Configuration $configuration
     * @param array $resolved
     * @param $parameters
     */
    public function __construct(Configuration $configuration, array $resolved, $parameters)
    {
        $this->resolved = $resolved;
        $this->parameters = $parameters;
        $this->configuration = $configuration;
    }

    public function resolve($class, $caller = '', $key=0){

        if(!class_exists($class)) return $this->resolveParameter($caller, $key);
        $arguments = [];
        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        if(is_null($constructor) && $reflection->isInstantiable()){
            $this->resolved[$class] = new $class;
            return $this->resolved[$class];
        }

        foreach ($constructor->getParameters() as $key => $reflectionParameter){
            $type = $reflectionParameter->getType();
            $name = ($type)?$type->getName():$reflectionParameter->getName();
            if(!isset($this->resolved[$name])){
                $this->resolved[$name] = $this->resolve($name, $class, $key);
            }
            $arguments[] = $this->resolved[$name];

        }
        $this->resolved[$class] = (count($arguments))?new $class(...$arguments): new $class;
        return $this->resolved[$class];

    }

    protected function resolveParameter($caller, $key){
        return $this->configuration->getArgument($caller, $key);
    }

    /**
     * @return array
     */
    public function getResolved(): array
    {
        return $this->resolved;
    }


}