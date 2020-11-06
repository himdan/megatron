<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 06/11/20
 * Time: 15:11
 */

namespace App\Controllers;


use MegatronFrameWork\Component\Controller;
use MegatronFrameWork\Component\Request;

class HomeController extends Controller
{

    public function index(Request $request){
        return $this->renderView('base.html.twig', ['x' => 10]);
    }

    public function test(Request $request){
        return $this->renderView('base.html.twig', ['x' => 10]);
    }

}