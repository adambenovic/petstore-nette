<?php

namespace App\Core\Entity;

class Pet extends XMLEntity
{
    public const XML_NAME = 'pet';

    private string $name;

    private string $status;

    public function getXMLName(): string
    {
        return static::XML_NAME;
    }

    public function getXMLData(): array
    {
        // TODO: Implement getXMLData() method.
    }
}