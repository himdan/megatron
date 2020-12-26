<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 06/11/20
 * Time: 12:59
 */

namespace MegatronFrameWork;



use MegatronFrameWork\Component\ErrorController;
use MegatronFrameWork\Component\Request;
use MegatronFrameWork\Component\Response;
use MegatronFrameWork\Component\Router;
use MegatronFrameWork\Db\EntityManager;
use MegatronFrameWork\DI\ArgumentResolver;
use MegatronFrameWork\DI\Container;
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
    protected $dbManager;
    /**
     * @var Container $container
     */
    protected $container;
    /**
     * @var Application $instance
     */
    protected static $instance;

    public function __construct(Environment $twig, $config = [])
    {
        $this->router = new Router();
        $this->container = new Container(new ArgumentResolver());
        $this->router->get('errors', [ErrorController::class, '_invoke']);
        $this->twig = $twig;
        $this->dbManager = EntityManager::boot($config);
    }

    public function handle(Request $request): Response
    {
        $this->request = $request;
        $function = new \Twig\TwigFunction('asset', function ($resource)use($request) {
            return  $request->getBaseUrl() . "/" .  $resource;
        });
        $this->twig->addFunction($function);
        try{
            $controller = $this->router->resolve($request);
            $this->context = [new $controller[0]($this->twig, $this->container) , $controller[1]];
            return call_user_func($this->context, $this->request);
        } catch(\Exception $exception){
            return call_user_func([new ErrorController($this->twig), '__invoke'], $request, $exception);
        }

    }



    public function terminate()
    {

    }

}