<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 27/12/20
 * Time: 12:16
 */

namespace App;


use MegatronFrameWork\Application;
use Twig\Environment;

class FontApplication extends Application
{
    public function __construct(Environment $twig, array $config = [], array $services = [])
    {
        parent::__construct($twig, $config, $services, __DIR__);
    }


}