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
        $valueType = $this->getType($propertyName, $data);

        foreach ($propertyTypes as $t) {
            if ($t->getName() === $valueType) {
                return $t;
            }
        }

        throw new RuntimeException('Unable to resolve '.$propertyName);
    }

    protected function getType(string $propertyName, array $data): string
    {
        $value = $data[$propertyName] ?? null;

        if($value === null){
            $value = $data;
        }

        if(is_string($value)){
            return 'string';
        }

        if(is_array($value) && array_is_list($value)){
            return 'array';
        }

        if(is_array($value) && !array_is_list($value)){
            return RichText::class;
        }

        return 'null';
    }
}
