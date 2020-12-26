<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 26/12/20
 * Time: 13:45
 */

namespace App\Service;


class FakeBService
{
    /**
     * @var FakeCService $fakeCService
     */
    protected $fakeCService;
    /**
     * @var FakeDService $fakeDService
     */
    protected $fakeDService;

    /**
     * FakeBService constructor.
     * @param FakeCService $fakeCService
     * @param FakeDService $fakeDService
     */
    public function __construct(FakeCService $fakeCService, FakeDService $fakeDService)
    {
        $this->fakeCService = $fakeCService;
        $this->fakeDService = $fakeDService;
    }


    public function getB()
    {
        return $this->fakeDService->getD() + $this->fakeCService->getC();
    }


}