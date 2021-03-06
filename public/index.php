<?php
use MegatronFrameWork\Component\Request;

require dirname(__DIR__).'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$parameters = $dotenv->load();
$services = [
    \App\Service\FakeService::class  => [1 => [
        'key' => 'val'
    ]],
    \App\Service\FakeCService::class => [20]
];

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../template');
$twig = new \Twig\Environment($loader, [
    'cache' => __DIR__.'/../runtime/cache',
]);
$twig = new \Twig\Environment($loader);

$request = Request::createFromGlobal();
$application = new App\FontApplication($twig,$parameters, $services);
$application
    ->router
    ->get('/', [\App\Controllers\DashboardController::class, 'index'])
    ->get('/orders', [\App\Controllers\OrderController::class, 'index'])
    ->get('/products', [\App\Controllers\ProductController::class, 'index'])
    ->get('/customers', [\App\Controllers\CustomerController::class, 'index'])
    ->get('/reports', [\App\Controllers\ReportController::class, 'index'])
    ->get('/integrations', [\App\Controllers\IntegrationController::class, 'index'])
    ->get('/login', [\App\Controllers\SecurityController::class, 'index'])
    ->post('/login', [\App\Controllers\SecurityController::class, 'login'])
;

$response = $application->handle($request);
$response->send();
$application->terminate();
