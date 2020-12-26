<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 26/12/20
 * Time: 13:43
 */

namespace App\Service;


class FakeService implements IFake
{
    /**
     * @var FakeAService $fakeAService
     */
    private $fakeAService;
    protected $parameters = [];

    /**
     * FakeService constructor.
     * @param FakeAService $fakeAService
     * @param array $parameters
     */
    public function __construct(FakeAService $fakeAService, array  $parameters)
    {
        $this->fakeAService = $fakeAService;
        $this->parameters = $parameters;
    }

    /**
     * @param $x
     * @return float|int
     */
    public function calculate($x)
    {
        return $this->fakeAService->getA() * $x;
    }


}