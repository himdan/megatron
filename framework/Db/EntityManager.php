<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 07/11/20
 * Time: 21:37
 */

namespace MegatronFrameWork\Db;


use Illuminate\Database\Capsule\Manager;

class EntityManager
{

    protected static $config = [

        "driver" => "mysql",

        "host" =>"127.0.0.1",

        "database" => "acl",

        "username" => "root",

        "password" => ""

    ];
    public static function  boot($config, $prefix='DB')
    {
        $capsule = new Manager();



        $capsule->addConnection(
            self::parseConfig($config, $prefix)
        );

//Make this Capsule instance available globally.
        $capsule->setAsGlobal();

// Setup the Eloquent ORM.
        $capsule->bootEloquent();
        return $capsule;

    }

    /**
     * @param $config
     * @param $prefix
     * @return array
     */
    protected static function parseConfig($config, $prefix){

        $configPass = [];
        foreach (self::$config as $key => $value)
        {
            $key_search = strtoupper(sprintf('%s_%s', $prefix, $key));
            $configPass[$key] = $config[$key_search]??'';

        }
        return $configPass;

    }

}