<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\RevenueWithdrawalStateType;
use SergiX44\Nutgram\Telegram\Types\Payment\RevenueWithdrawalState;
use SergiX44\Nutgram\Telegram\Types\Payment\RevenueWithdrawalStateFailed;
use SergiX44\Nutgram\Telegram\Types\Payment\RevenueWithdrawalStatePending;
use SergiX44\Nutgram\Telegram\Types\Payment\RevenueWithdrawalStateSucceeded;

#[Attribute(Attribute::TARGET_CLASS)]
class RevenueWithdrawalStateResolver extends ConcreteResolver
{
    protected array $concretes = [
        RevenueWithdrawalStateType::PENDING->value => RevenueWithdrawalStatePending::class,
        RevenueWithdrawalStateType::SUCCEEDED->value => RevenueWithdrawalStateSucceeded::class,
        RevenueWithdrawalStateType::FAILED->value => RevenueWithdrawalStateFailed::class,
    ];

    public function concreteFor(array $data, array $all): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ?? (new class extends RevenueWithdrawalState {
        })::class;
    }
}
