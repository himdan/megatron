<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 06/11/20
 * Time: 14:44
 */

namespace MegatronFrameWork\Errors;


class NotFoundException extends \Exception
{
    public $code = 404;
}