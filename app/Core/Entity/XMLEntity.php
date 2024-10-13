<?php

declare(strict_types=1);

namespace App\Core\Entity;

use Exception;
use SimpleXMLElement;

abstract class XMLEntity implements DatabaseEntity
{
    public const string XML_PATH = 'database.xml';

    protected int $id;

    abstract public function getXMLName(): string;

    abstract public function getXMLData(): array;

    abstract public function load(): void;

    public function getXMLPath(): ?string
    {
        return static::XML_PATH;
    }

    /**
     * @throws Exception
     */
    public function toXML(): SimpleXMLElement
    {
        $xml = new SimpleXMLElement('<' . $this->getXMLName() . '></' . $this->getXMLName() . '>');
        $xml->addChild('id', (string)$this->getId());

        foreach ($this->getXMLData() as $key => $value) {
            $xml->addChild($key, $value);
        }

        return $xml;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
