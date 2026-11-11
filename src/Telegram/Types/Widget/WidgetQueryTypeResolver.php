<?php

namespace SergiX44\Nutgram\Telegram\Types\Widget;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\WidgetQueryTypeType;

#[Attribute(Attribute::TARGET_CLASS)]
class WidgetQueryTypeResolver extends ConcreteResolver
{
    protected array $concretes = [
        WidgetQueryTypeType::DATA->value => WidgetQueryTypeData::class,
        WidgetQueryTypeType::SIGN_DATA->value => WidgetQueryTypeSignData::class,
        WidgetQueryTypeType::SENT_TRANSACTION->value => WidgetQueryTypeSentTransaction::class,
    ];

    public function concreteFor(array $data, array $all): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ?? (new class implements WidgetQueryType {
        })::class;
    }
}
