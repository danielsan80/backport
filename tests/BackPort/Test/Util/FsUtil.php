<?php

namespace Tests\BackPort\Test\Util;

class FsUtil
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

    public static function tmpDir()
    {
        $dir = self::projectDir().'/.tmp';
        if (!file_exists($dir)) {
            mkdir($dir, 0775, true);
        }
        return $dir;
    }

    public static function closest($path)
    {
        $path = trim($path, '/');
        $currentDir = __DIR__;
        $i=0;
        while (!file_exists($currentDir.'/'.$path)) {
            $currentDir = \dirname($currentDir);
            if ($i++>=10) {
                throw new \InvalidArgumentException($path.' not found');
            }
        }
        $currentDir = realpath($currentDir);

        return $currentDir.'/'.$path;
    }
}