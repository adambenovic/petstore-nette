<?php

declare(strict_types=1);

namespace App\Core\Entity;

use ReflectionClass;
use ReflectionException;

final class XMLEntityFactory implements EntityFactory
{
    /**
     * @throws ReflectionException
     */
    public function create(array $data, string $class): Entity
    {
        $entity = new $class();

        if (!$entity instanceof XMLEntity) {
            throw new \InvalidArgumentException('Class ' . $class . ' is not an instance of ' . XMLEntity::class);
        }

        $reflectionClass = new ReflectionClass($class);

        foreach ($data as $property => $value) {
            try {
                $reflectionProperty = $reflectionClass->getProperty($property);
            } catch (ReflectionException $e) {
                throw new \InvalidArgumentException('Property not found in class ' . $class);
            }

            $type = $reflectionProperty->getType();

            if ($type === null) {
                $entity->{'set'.ucfirst($property)}($value);
            }

            $valueCast = $this->castValue($type->getName(), $type->allowsNull(), $value);
            $entity->{'set'.ucfirst($property)}($valueCast);
        }

        return $entity;
    }

    private function castValue(mixed $value, bool $allowsNull, string $type): mixed
    {
        if ($allowsNull && $value === null) {
            return null;
        }

        switch ($type) {
            case 'int':
                $value = (int) $value;
                break;
            case 'float':
                $value = (float) $value;
                break;
            case 'string':
                $value = (string) $value;
                break;
            case 'bool':
                $value = (bool) $value;
                break;
            case 'array':
                $value = (array) $value;
                break;
            default:
                // If it's a class name, ensure $variable is an instance of that class
                if (class_exists($type) && !$value instanceof $type) {
                    throw new \InvalidArgumentException("Variable must be an instance of {$type}");
                }
        }

        return $value;
    }
}
