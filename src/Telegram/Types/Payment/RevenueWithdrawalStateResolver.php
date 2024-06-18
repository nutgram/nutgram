<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\RevenueWithdrawalStateType;

#[Attribute(Attribute::TARGET_CLASS)]
class RevenueWithdrawalStateResolver extends ConcreteResolver
{
    public function concreteFor(array $data): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');

        return match ($type) {
            RevenueWithdrawalStateType::PENDING->value => RevenueWithdrawalStatePending::class,
            RevenueWithdrawalStateType::SUCCEEDED->value => RevenueWithdrawalStateSucceeded::class,
            RevenueWithdrawalStateType::FAILED->value => RevenueWithdrawalStateFailed::class,
            default => (new class extends RevenueWithdrawalState {
            })::class,
        };
    }
}
