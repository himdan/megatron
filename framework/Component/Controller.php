<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 06/11/20
 * Time: 17:16
 */

namespace MegatronFrameWork\Component;


use MegatronFrameWork\DI\Container;
use Twig\Environment;

class Controller
{
    /**
     * @var Environment
     */
    protected $twig;
    /**
     * @var Container $container
     */
    protected $container;
    public function __construct(Environment $twig, Container $container)
    {
        $this->twig = $twig;
        $this->container = $container;
    }

    public function renderView($view, $args)
    {
        $response = new Response();
        $response->setContent($this->twig->render($view, $args));
        return $response;

    }

    /**
     * @param $name
     * @return $name
     */
    public function get($name)
    {
        return $this->container->get($name);
    }
}