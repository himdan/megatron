<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 27/12/20
 * Time: 13:54
 */

namespace MegatronFrameWork\utility;


use Symfony\Component\Finder\Finder;

class ClassUtility
{

    protected $rootDir;

    /**
     * ClassUtility constructor.
     * @param $rootDir
     */
    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    public function getClassThatImplement($interfaceName)
    {
        $finder = new Finder();
        $classes = [];
        $finder->files()->in($this->rootDir)->filter(function (\SplFileInfo $file) use ($interfaceName) {
            $interfaces = class_implements($this->toFQCN($file->getRealPath()), true);
            if ($interfaces === false) return false;
            return in_array($interfaceName, $interfaces);
        });

        foreach ($finder as $fileInfo) {

            array_push($classes, $this->toFQCN($fileInfo->getRealPath()));
        }

        return $classes;
    }

    public function toFQCN($path)
    {
        return str_replace([$this->rootDir, '.php', '/'], ['App', '', '\\'], $path);
    }
}