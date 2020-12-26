<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 26/12/20
 * Time: 13:17
 */

namespace MegatronFrameWork\DI;


class Container
{

    /**
     * @var ArgumentResolver $argumentsResolver
     */
    private $argumentsResolver;
    protected $registry = [];

    /**
     * Container constructor.
     * @param ArgumentResolver $argumentsResolver
     */
    public function __construct(ArgumentResolver $argumentsResolver)
    {
        $this->argumentsResolver = $argumentsResolver;
    }

    public function get($class)
    {

        if(isset($this->registry[$class])) return $this->registry[$class];
        return $this->argumentsResolver->resolve($class);
    }


}