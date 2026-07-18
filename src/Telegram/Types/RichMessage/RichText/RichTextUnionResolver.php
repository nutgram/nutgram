<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use Attribute;
use ReflectionType;
use RuntimeException;
use SergiX44\Hydrator\Annotation\UnionResolver;

#[Attribute(Attribute::TARGET_PROPERTY)]
class RichTextUnionResolver extends UnionResolver
{
    public function resolve(string $propertyName, array $propertyTypes, array $data): ReflectionType
    {
        $value = $data[$propertyName] ?? null;
        $valueType = gettype($value);

        $valueType = match ($valueType) {
            'NULL' => 'null',
            'object' => RichText::class,
            default => $valueType,
        };

        foreach ($propertyTypes as $t) {
            if ($t->getName() === $valueType) {
                return $t;
            }
        }

        throw new RuntimeException('Unable to resolve '.$propertyName);
    }
}
