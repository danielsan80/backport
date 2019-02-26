<?php

namespace Tests\BackPort;

use BackPort\Backporter;
use PHPUnit\Framework\TestCase;
use Tests\BackPort\Test\Util\FsUtil;

class BackporterTest extends TestCase
{

    /**
     * @test
     */
    public function it_works()
    {

        $backporter = new Backporter();

        $before = file_get_contents(FsUtil::closest('Test/file/before/AClass.php'));

        $after = $backporter->port($before);
        $this->assertEquals(file_get_contents(FsUtil::closest('Test/file/after/AClass.php')), $after);

    }

}
