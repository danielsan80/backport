<?php

namespace BackPort;

class Client
{

    public function execute($projectDir, array $dirs)
    {

        exec('git status', $output);
        $branch = null;
        foreach ($output as $line) {
            $parts = explode('On branch ', $line);
            if (count($parts)>1) {
                $branch = $parts[1];
                break;
            }
        }

        if (!$branch) {
            throw new \Exception('Branch name not found');
        }

        if (!preg_match('/\_bp?/', $branch)) {
            throw new \Exception('You are not on a `*_bp` branch');
        }

        $backporter = new DirectoryBackPorter();

        foreach($dirs as $dir) {
            $backporter->port($dir);
        }

        if (file_exists($projectDir.'/composer.json')) {
            $content = file_get_contents($projectDir.'/composer.json');
            $content = preg_replace('/"php": "[^"]+"/', '"php": ">=7.0"', $content);
            file_put_contents($projectDir.'/composer.json', $content);
        }

    }

}