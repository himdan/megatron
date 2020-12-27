<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 26/12/20
 * Time: 13:22
 */

namespace MegatronFrameWork\DI;

use MegatronFrameWork\Component\Configuration;
use MegatronFrameWork\utility\ClassUtility;

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
     * @var ClassUtility $classUtility
     */
    protected $classUtility;

    /**
     * ArgumentResolver constructor.
     * @param Configuration $configuration
     * @param ClassUtility $classUtility
     * @param array $resolved
     * @param $parameters
     */
    public function __construct(Configuration $configuration, ClassUtility $classUtility, array $resolved, $parameters)
    {
        $this->resolved = $resolved;
        $this->parameters = $parameters;
        $this->configuration = $configuration;
        $this->classUtility = $classUtility;
    }

    public function resolve($class, $method = '__construct')
    {

        if (isset($this->resolved[$class]) && $method === '__construct') {

            return $this->resolved[$class];
        }
        $reflection = new \ReflectionClass($class);
        $reflectionMethod = ($method === '__construct') ? $reflection->getConstructor() : $reflection->getMethod($method);
        $arguments = [];
        if (is_null($reflectionMethod)) return $this->instantiate($class, $method, []);
        foreach ($reflectionMethod->getParameters() as $key => $parameter) {
            if (($parameterClass = $parameter->getClass()) && $parameterClass->isInstantiable()) {
                $this->resolved[$parameterClass->getName()] = $this->resolve($parameterClass->getName());
                $arguments[] = $this->resolved[$parameterClass->getName()];
            } elseif (($parameterClass = $parameter->getClass()) && $parameterClass->isInterface()) {
                $classes = $this->classUtility->getClassThatImplement($parameterClass->getName());
                if (count($classes) !== 1) {
                    throw new \Exception(
                        'too many candidate for interface %s',
                        $parameterClass->getName());
                }
                $this->resolved[$parameterClass->getName()] = $this->resolve($classes[0]);
                $arguments[] = $this->resolved[$parameterClass->getName()];
            } elseif (($parameterClass = $parameter->getClass()) && $parameterClass->isAbstract()) {
                // todo implement abstract class resolver
            } elseif (!$parameter->getClass()) {
                $arguments[] = $this->resolveParameter($class, $key);
            }
        }
        return $this->instantiate($class, $method, $arguments);

    }

    protected function instantiate($class, $method, $arguments)
    {

        if ($method === '__construct') {
            $this->resolved[$class] = new $class(...$arguments);
            return $this->resolved[$class];
        } else {
            return call_user_func([$this->resolved[$class], $method], ...$arguments);
        }
    }

    protected function resolveParameter($caller, $key)
    {
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