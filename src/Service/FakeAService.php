<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 26/12/20
 * Time: 13:44
 */

namespace App\Service;


class FakeAService
{
    /**
     * @var FakeBService $fakeBService
     */
    protected $fakeBService;

    /**
     * FakeAService constructor.
     * @param FakeBService $fakeBService
     */
    public function __construct(FakeBService $fakeBService)
    {
        $this->fakeBService = $fakeBService;
    }

    public function getA(){
        return 30 * $this->fakeBService->getB();
    }

}