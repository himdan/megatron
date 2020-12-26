<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 26/12/20
 * Time: 13:47
 */

namespace App\Service;


class FakeCService
{

    protected $y;
    /**
     * FakeCService constructor.
     * @param int $y
     */
    public function __construct($y)
    {
        $this->y = $y;
    }

    public function getC()
    {
        return 10 * $this->y;
    }
}