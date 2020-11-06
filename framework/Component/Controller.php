<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 06/11/20
 * Time: 17:16
 */

namespace MegatronFrameWork\Component;


use Twig\Environment;

class Controller
{
    /**
     * @var Environment
     */
    protected $twig;
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function renderView($view, $args)
    {
        $response = new Response();
        $response->setContent($this->twig->render($view, $args));
        return $response;

    }
}