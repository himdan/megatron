<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 26/12/20
 * Time: 21:35
 */

namespace App\Service;


interface IFake
{
    /**
     * @param $x
     * @return float|int
     */
    public function calculate($x);
}