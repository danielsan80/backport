<?php

namespace Tests\BackPort;

use BackPort\DirectoryBackPorter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use Tests\BackPort\Test\Util\FsUtil;

class DirectoryBackPorterTest extends TestCase
{
    const TEST_DIR = '/backporter';

    public function setUp()
    {
        if (file_exists(FsUtil::tmpDir() . self::TEST_DIR)) {
            exec(sprintf('rm -rf %s/backporter',
                FsUtil::tmpDir()
            ));
        }
        mkdir(FsUtil::tmpDir() . self::TEST_DIR . '/after', 0777, true);

        exec(sprintf('cp -r %s %s/',
            FsUtil::closest('Test/directory/before'),
            FsUtil::tmpDir() . self::TEST_DIR
        ));
    }

    /**
     * @test
     */
    public function it_can_backport_a_directory_in_another_directory()
    {
        $backporter = new DirectoryBackPorter();

        $backporter->port(
            FsUtil::tmpDir() . self::TEST_DIR . '/before',
            FsUtil::tmpDir() . self::TEST_DIR . '/after'
        );


        $this->assertDirEquals(
            FsUtil::closest('Test/directory/after'),
            FsUtil::tmpDir() . self::TEST_DIR . '/after'
        );

    }

    /**
     * @test
     */
    public function it_can_backport_a_directory()
    {

        $backporter = new DirectoryBackPorter();

        $backporter->port(FsUtil::tmpDir() . self::TEST_DIR . '/before');

        $this->assertDirEquals(
            FsUtil::closest('Test/directory/after'),
            FsUtil::tmpDir() . self::TEST_DIR . '/before'
        );

    }

    protected function assertDirEquals($expected, $actual)
    {
        $this->assertDirContained($expected, $actual);
        $this->assertDirContained($actual, $expected);
    }

    protected function assertDirContained($expected, $actual)
    {
        $finder = new Finder();
        $finder->in($actual)
            ->files()
            ->depth('>= 0');

        foreach ($finder as $file) {
            $relativePathname = $file->getRelativePathname();

            $this->assertFileExists($expected . '/' . $relativePathname);
            $this->assertFileEquals(
                $actual . '/' . $relativePathname,
                $expected . '/' . $relativePathname
            );

        }
    }


}
