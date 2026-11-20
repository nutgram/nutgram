<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\WidgetQueryTypeType;
use SergiX44\Nutgram\Telegram\Types\Widget\WidgetQueryType;
use SergiX44\Nutgram\Telegram\Types\Widget\WidgetQueryTypeData;
use SergiX44\Nutgram\Telegram\Types\Widget\WidgetQueryTypeSentTransaction;
use SergiX44\Nutgram\Telegram\Types\Widget\WidgetQueryTypeSignData;

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
