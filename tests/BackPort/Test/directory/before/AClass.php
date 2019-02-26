<?php

namespace ANamespace;
use ANamespace\AnotherClass;

/**
 * Class AClass
 * @package Tests\BackPort\Test\Classes
 */
class AClass
{

    public function setString(?string $string): void
    {
        // a comment
    }

    public function setAnotherClass(?AnotherClass $anotherObject): ?AnotherClass
    {
    }

    public function setDateTime(\DateTime $dateTime): \DateTime
    {
    }
}