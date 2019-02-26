<?php

namespace BackPort\Util;

class FSUtil
{
    protected static $projectDir;

    public static function projectDir(): string
    {
        if (!self::$projectDir) {
            $dir = __DIR__;
            $i=0;
            while (!file_exists($dir.'/composer.json')) {
                $dir = \dirname($dir);
                if ($i++>=10) {
                    throw new \InvalidArgumentException('Project dir not found');
                }
            }
            $dir = realpath($dir);
        }

        return $dir;
    }

}