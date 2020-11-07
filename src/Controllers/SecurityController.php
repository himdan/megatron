<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 07/11/20
 * Time: 20:36
 */

namespace App\Controllers;


use MegatronFrameWork\Component\Controller;
use MegatronFrameWork\Component\Request;

class SecurityController extends Controller
{
    public function index(Request $request){
        return $this->renderView('landing.html.twig', []);
    }

    public function login(Request $request){

       $email = $request->getRequest('email');
       $password = $request->getRequest('password');
       var_dump($email, $password);
       die();


    }

    public function logout(Request $request)
    {

    }
}