<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 06/11/20
 * Time: 12:59
 */

namespace MegatronFrameWork;


use MegatronFrameWork\Component\Request;
use MegatronFrameWork\Component\Response;
use MegatronFrameWork\Component\Router;
use Twig\Environment;

class Application
{
    /**
     * @var Router  $router
     */
    public $router;
    protected  $request;
    protected $response;
    protected $context;
    protected $twig;
    /**
     * @var Application $instance
     */
    protected static $instance;

    public function __construct(Environment $twig)
    {
        $this->router = new Router();
        $this->twig = $twig;

    }

    public function handle(Request $request): Response
    {
        $this->request = $request;
        $function = new \Twig\TwigFunction('asset', function ($resource)use($request) {
            return  $request->getBaseUrl() . "/" .  $resource;
        });
        $this->twig->addFunction($function);
        $controller = $this->router->resolve($request);
        $this->context = [new $controller[0]($this->twig) , $controller[1]];
        return call_user_func($this->context, $this->request);
    }

    public function terminate()
    {

    }

}