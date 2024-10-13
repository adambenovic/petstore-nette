<?php

declare(strict_types=1);

namespace App\Core\Entity;

interface EntityFactory
{
    public function create(array $data, string $class): Entity;
}
