<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 06/11/20
 * Time: 15:11
 */

namespace App\Controllers;


use App\Service\FakeService;
use App\Service\IFake;
use MegatronFrameWork\Component\Controller;
use MegatronFrameWork\Component\Request;

class DashboardController extends Controller
{

    public function index(Request $request, IFake $fakeService){
        $length = $request->get('length',0);
        $value = $fakeService->calculate(35);
        return $this->renderView('pages/dashboard/index.html.twig', ['length' => $length, 'value' => $value]);
    }

}