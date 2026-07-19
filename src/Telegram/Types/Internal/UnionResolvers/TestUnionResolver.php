<?php

namespace SergiX44\Nutgram\Telegram\Types\Internal\UnionResolvers;

use Attribute;
use ReflectionType;
use SergiX44\Hydrator\Annotation\UnionResolver;
use SergiX44\Hydrator\Exception\UnsupportedPropertyTypeException;

#[Attribute(Attribute::TARGET_PROPERTY)]
class TestUnionResolver extends UnionResolver
{
    public function __construct(protected ?string $type = null)
    {
    }

    public function resolve(string $propertyName, array $propertyTypes, array $data): ReflectionType
    {
        //! This resolver is used ONLY to test telegram types' properties with union types.

        if ($this->type === null) {
            return array_first($propertyTypes);
        }

        foreach ($propertyTypes as $property) {
            if ($property->getName() === $this->type) {
                return $property;
            }
        }

        throw new UnsupportedPropertyTypeException(
            sprintf(
                'The property "%s" can only be %s, %s given.',
                $propertyName,
                implode(', ', $propertyTypes),
                $this->type,
            )
        );
    }
}
