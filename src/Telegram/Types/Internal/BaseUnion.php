<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal;

use Attribute;
use ReflectionType;
use SergiX44\Hydrator\Annotation\UnionResolver;
use SergiX44\Hydrator\Exception\UnsupportedPropertyTypeException;

#[Attribute(Attribute::TARGET_PROPERTY)]
class BaseUnion extends UnionResolver
{
    public function resolve(string $propertyName, array $propertyTypes, array $data): ReflectionType
    {
        $value = $data[$propertyName] ?? null;
        $firstScalarType = null;

        $varType = $this->getVarType($value);
        foreach ($propertyTypes as $type) {
            if ($firstScalarType === null && $type->isBuiltin()) {
                $firstScalarType = $type;
            }

            if ($type->getName() === $varType) {
                return $type;
            }
        }

        if ($firstScalarType !== null) {
            return $firstScalarType;
        }

        throw new UnsupportedPropertyTypeException(
            sprintf(
                'The property "%s" can only be %s, %s given.',
                $propertyName,
                implode(', ', $propertyTypes),
                $varType,
            )
        );
    }

    protected function getVarType(mixed $value): string
    {
        $valueType = gettype($value);

        return match ($valueType) {
            'integer' => 'int',
            'double' => 'float',
            'boolean' => 'bool',
            'NULL' => 'null',
            default => $valueType,
        };
    }
}
