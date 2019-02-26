<?php

namespace ANamespace;

use ANamespace\ASubNamespace\AnotherClass;
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
    public function setName($name)
    {
    }
    public function returnString()
    {
    }
    public function setAnotherClass(AnotherClass $anotherObject = null)
    {
    }
    public function setDateTime(\DateTime $dateTime)
    {
    }
    public function id()
    {
        $id = 'an_id';
        return (string) $id;
    }
    public function id()
    {
        $id = 'an_id';
        return (string) $id;
    }
}