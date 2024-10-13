<?php

namespace App\Core\Entity;

class Category extends XMLEntity
{
    public const XML_NAME = 'category';

    private string $name;

    public function getXMLName(): string
    {
        return static::XML_NAME;
    }

    public function getXMLData(): array
    {
        return [
            'name' => $this->getName()
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}