<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 07/11/20
 * Time: 10:26
 */

namespace MegatronFrameWork\Component;

/**
 * Class ErrorController
 * @package MegatronFrameWork\Component
 */
class ErrorController extends Controller
{


    public function __invoke(Request $request, \Exception $exception)
    {
        try{
            $response = $this->renderView('errors.html.twig', ['request' => $request, 'e' => $exception]);
            $response->setStatus($exception->getCode());
            return $response;
        } catch (\Exception $exception2){
            $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../template');
            $this->twig->setLoader($loader);
            $response = $this->renderView('errors.html.twig', ['request' => $request, 'e' => $exception]);
            $response->setStatus($exception->getCode());
            return $response;

        }

    }

}