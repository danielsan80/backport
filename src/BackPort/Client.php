<?php

namespace BackPort;

class Client
{
    protected $projectDir;
    protected $dirsToPort = [];
    protected $composerJsonReplacements =[
        [
            'pattern' => '/"php": "[^"]+"/',
            'replacement' => '"php": ">=7.0"'
        ]
    ];

    public function setProjectDir($projectDir)
    {
        $this->projectDir = $projectDir;
        return $this;
    }

    public function setDirsToPort(array $dirs)
    {
        $this->dirsToPort = $dirs;
        return $this;
    }

    public function addDirToPort($dir)
    {
        $this->dirsToPort[] = $dir;
        return $this;
    }

    public function addComposerJsonReplacement($pattern, $replacement)
    {
        $this->composerJsonReplacements[] = [
            'pattern' => $pattern,
            'replacement' => $replacement,
        ];

        return $this;

    }

    public function execute()
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

        foreach($this->dirsToPort as $dir) {
            $backporter->port($dir);
        }

        if ($this->composerJsonReplacements) {
            if (!$this->projectDir) {
                throw new \InvalidArgumentException('ProjectDir is not set');

            }
            if (!file_exists($this->projectDir.'/composer.json')) {
                throw new \InvalidArgumentException('composer.json does not exist');

            }

            $content = file_get_contents($this->projectDir.'/composer.json');
            foreach ($this->composerJsonReplacements as $item) {
                $content = preg_replace($item['pattern'], $item['replacement'], $content);
            }
            file_put_contents($this->projectDir.'/composer.json', $content);
        }


    }

}