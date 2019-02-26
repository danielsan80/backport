<?php

namespace BackPort;

use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;

class DirectoryBackPorter
{

    public function port($sourceDir, $targetDir = false)
    {
        if (!$targetDir)
        {
            $targetDir = $sourceDir;
        }

        $backporter = new Backporter();

        $dir = new \RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file)
        {
            $newPath = preg_replace("#^" . preg_quote($sourceDir) . "#", $targetDir, $file);

            if ($file->isDir() && !file_exists($newPath))
            {
                mkdir($newPath,0777, true);
                continue;
            }

            if ($file->isFile() && in_array($file->getExtension(), ['php']))
            {
                $code = file_get_contents($file);
                $code =  $backporter->port($code);
                file_put_contents($newPath,$code);
            }
        }
    }
}