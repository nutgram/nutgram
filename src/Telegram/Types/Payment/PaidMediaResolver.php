<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\PaidMediaType;
use SergiX44\Nutgram\Telegram\Properties\TransactionPartnerType;

#[Attribute(Attribute::TARGET_CLASS)]
class PaidMediaResolver extends ConcreteResolver
{
    public function concreteFor(array $data): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');

        return match ($type) {
            PaidMediaType::PREVIEW->value => PaidMediaPreview::class,
            PaidMediaType::PHOTO->value => PaidMediaPhoto::class,
            PaidMediaType::VIDEO->value => PaidMediaVideo::class,
            default => (new class extends PaidMedia {
            })::class,
        };
    }
}
