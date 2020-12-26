<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 06/11/20
 * Time: 12:59
 */

namespace MegatronFrameWork;


use MegatronFrameWork\Component\Configuration;
use MegatronFrameWork\Component\ErrorController;
use MegatronFrameWork\Component\Request;
use MegatronFrameWork\Component\Response;
use MegatronFrameWork\Component\Router;
use MegatronFrameWork\Db\EntityManager;
use MegatronFrameWork\DI\Container;
use Twig\Environment;

class Application
{
    /**
     * @var Router $router
     */
    public $router;
    protected $request;
    protected $response;
    protected $context;
    protected $twig;
    protected $dbManager;
    /**
     * @var Configuration $configuration
     */
    protected $configuration;
    /**
     * @var Container $container
     */
    protected $container;
    /**
     * @var Application $instance
     */
    protected static $instance;

    public function __construct(Environment $twig, $config = [], $services = [])
    {
        $this->router = new Router();
        $this->router->get('errors', [ErrorController::class, '_invoke']);
        $this->twig = $twig;
        $this->configuration = (new Configuration())->load($config, $services);
        $this->dbManager = EntityManager::boot($config);
        $this->container = new Container($this->configuration, [
            Configuration::class => $this->configuration,
            Environment::class => $this->twig,

        ], [

        ]);

    }

    public function handle(Request $request): Response
    {
        $this->request = $request;
        $function = new \Twig\TwigFunction('asset', function ($resource) use ($request) {
            return $request->getBaseUrl() . "/" . $resource;
        });
        $this->twig->addFunction($function);
        try {
            $controller = $this->router->resolve($request);
            $this->context = [$this->container->get($controller[0]), $controller[1]];
            return call_user_func($this->context, $this->request);
        } catch (\Exception $exception) {
            return call_user_func([new ErrorController($this->twig, $this->container), '__invoke'], $request, $exception);
        }

    }


    public function terminate()
    {

    }

}