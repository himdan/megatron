<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 26/12/20
 * Time: 13:17
 */

namespace MegatronFrameWork\DI;


use MegatronFrameWork\Component\Configuration;
use MegatronFrameWork\utility\ClassUtility;

class Container
{

    /**
     * @var ArgumentResolver $argumentsResolver
     */
    private $argumentsResolver;
    protected $registry = [];
    /**
     * @var Configuration $configuration
     */
    protected $configuration;
    /**
     * @var ClassUtility $classUtility
     */
    protected $classUtility;


    /**
     * Container constructor.
     * @param Configuration $configuration
     * @param ClassUtility $classUtility
     * @param array $precompiled
     * @param array $parameters
     */
    public function __construct(Configuration $configuration,ClassUtility $classUtility,$precompiled = [], $parameters = [])
    {
        $precompiled[Container::class] = $this;
        $this->argumentsResolver = new ArgumentResolver($configuration, $classUtility, $precompiled, $parameters);
        $this->registry = array_merge($this->registry, $precompiled);
    }

    public function get($class)
    {
        if(isset($this->registry[$class])) return $this->registry[$class];
        $this->registry[$class] = $this->argumentsResolver->resolve($class);
        return $this->registry[$class];
    }

    public function getContext($context){
        return $this->argumentsResolver->resolve(get_class($context[0]), $context[1]);
    }

    public function registerResolved($object)
    {
        $this->registry[get_class($object)] = $object;
    }


}