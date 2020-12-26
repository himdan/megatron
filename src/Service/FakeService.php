<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 26/12/20
 * Time: 13:43
 */

namespace App\Service;


class FakeService
{
    /**
     * @var FakeAService $fakeAService
     */
    private $fakeAService;

    /**
     * FakeService constructor.
     * @param FakeAService $fakeAService
     */
    public function __construct(FakeAService $fakeAService)
    {
        $this->fakeAService = $fakeAService;
    }


    public function calculate($x){
        return $this->fakeAService->getA() * $x;
    }


}