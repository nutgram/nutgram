<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\TransactionPartnerType;

#[Attribute(Attribute::TARGET_CLASS)]
class TransactionPartnerResolver extends ConcreteResolver
{
    public function concreteFor(array $data): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');

        return match ($type) {
            TransactionPartnerType::FRAGMENT->value => TransactionPartnerFragment::class,
            TransactionPartnerType::USER->value => TransactionPartnerUser::class,
            TransactionPartnerType::OTHER->value => TransactionPartnerOther::class,
            default => (new class extends TransactionPartner {
            })::class,
        };
    }
}
