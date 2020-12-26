<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 26/12/20
 * Time: 13:17
 */

namespace MegatronFrameWork\DI;


use MegatronFrameWork\Component\Configuration;

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
     * Container constructor.
     * @param Configuration $configuration
     * @param array $precompiled
     * @param array $parameters
     */
    public function __construct(Configuration $configuration,$precompiled = [], $parameters = [])
    {
        $precompiled[Container::class] = $this;
        $this->argumentsResolver = new ArgumentResolver($configuration, $precompiled, $parameters);
        $this->registry = array_merge($this->registry, $precompiled);
    }

    public function get($class)
    {

        if(isset($this->registry[$class])) return $this->registry[$class];
        $this->registry[$class] = $this->argumentsResolver->resolve($class);
        return $this->registry[$class];
    }


}