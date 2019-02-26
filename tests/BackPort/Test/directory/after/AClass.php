<?php

namespace ANamespace;

use ANamespace\AnotherClass;
/**
 * Class AClass
 * @package Tests\BackPort\Test\Classes
 */
class AClass
{
    public function setString($string = null)
    {
        // a comment
    }
    public function setAnotherClass(AnotherClass $anotherObject = null)
    {
    }
    public function setDateTime(\DateTime $dateTime)
    {
    }
}