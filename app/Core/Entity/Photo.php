<?php

namespace App\Core\Entity;

class Photo extends XMLEntity
{
    public const XML_NAME = 'photo_url';

    private string $url;

    public function getXMLName(): string
    {
        return static::XML_NAME;
    }

    public function getXMLData(): array
    {
        return [
            'photoUrl' => $this->getUrl()
        ];
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}