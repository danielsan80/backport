<?php

namespace ANamespace;
use ANamespace\ASubNamespace\AnotherClass;

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

    public function setName(string $name): void
    {
    }

    public function returnString(): string
    {

    }

    public function setAnotherClass(?AnotherClass $anotherObject): ?AnotherClass
    {
    }

    public function setDateTime(\DateTime $dateTime): \DateTime
    {
    }

    public function id(): string
    {
        $id = 'an_id';

        return $id;

    }

    public function id(): string
    {
        $id = 'an_id';

        return (string)$id;

    }

}