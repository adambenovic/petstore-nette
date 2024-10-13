<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Entity\Entity;
use SimpleXMLElement;

final class XMLDatabase
{
    protected int $id;

    public function save(Entity $entity): void
    {
        $path = $entity->getXMLPath();
        $xml = $this->loadXML($path);
        $xml = $this->appendXML($xml, $entity->toXml());
        $xml->asXML($path);
    }

    public function getAll(string $path, string $class): array
    {
        $xml = $this->loadXML($path);
        $entities = [];

        $xml->getChildren()->each(function (SimpleXMLElement $child) use ($class, &$entities) {
            $entity = new $class;
            $entity->load($child);
            $entities[] = $entity;
        });

        return $entities;
    }

    private function loadXML(string $path): SimpleXMLElement
    {
        $fileContents = file_get_contents($path);

        if (!empty($fileContents)) {
            return simplexml_load_string($fileContents);
        }

        return new SimpleXMLElement('<database></database>');
    }

    private function appendXML(SimpleXMLElement $xml, SimpleXMLElement $objectXml): SimpleXMLElement
    {
        $xml->addChild($objectXml->getName(), $objectXml->asXML());

        return $xml;
    }
}
