<?php

namespace BackPort;

class Client
{

    public function execute(array $dirs)
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

    }

}