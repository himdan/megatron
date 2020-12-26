<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 06/11/20
 * Time: 15:11
 */

namespace App\Controllers;


use App\Service\FakeCService;
use App\Service\FakeService;
use MegatronFrameWork\Component\Controller;
use MegatronFrameWork\Component\Request;

class IntegrationController extends Controller
{

    public function index(Request $request){
        $value = $this->get(FakeService::class)->calculate(10);
        $value2 = $this->get(FakeCService::class)->getC();
        $length = $request->get('length',0);
        return $this->renderView('pages/integration/index.html.twig', ['length' => $length,
            'value' => $value,
            'value2' => $value2
        ]);
    }

}