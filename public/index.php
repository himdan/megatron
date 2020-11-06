<?php
use MegatronFrameWork\Component\Request;

require dirname(__DIR__).'/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../template');
$twig = new \Twig\Environment($loader, [
    'cache' => __DIR__.'/../runtime/cache',
]);
$twig = new \Twig\Environment($loader);

$request = Request::createFromGlobal();
$application = new \MegatronFrameWork\Application($twig);
$application
    ->router
    ->get('/xyz/{\d+}/lyz/{\w+}', [\App\Controllers\HomeController::class, 'index'])
    ->get('/xyz', [\App\Controllers\HomeController::class, 'test']);

$response = $application->handle($request);
$response->send();
$application->terminate();
