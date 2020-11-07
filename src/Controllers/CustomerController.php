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

class CustomerController extends Controller
{

    public function index(Request $request){
        $length = $request->get('length',0);
        return $this->renderView('pages/customer/index.html.twig', ['length' => $length]);
    }

}