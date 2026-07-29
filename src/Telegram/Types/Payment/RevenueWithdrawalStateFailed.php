<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RevenueWithdrawalStateType;

/**
 * The withdrawal failed and the transaction was refunded.
 * @see https://core.telegram.org/bots/api#revenuewithdrawalstatefailed
 */
class RevenueWithdrawalStateFailed extends RevenueWithdrawalState
{
    /**
     * Type of the state, always “failed”
     */
    #[EnumOrScalar]
    public RevenueWithdrawalStateType|string $type = RevenueWithdrawalStateType::FAILED;
}
