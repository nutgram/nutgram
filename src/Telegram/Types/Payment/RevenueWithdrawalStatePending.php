<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RevenueWithdrawalStateType;

/**
 * The withdrawal is in progress.
 * @see https://core.telegram.org/bots/api#revenuewithdrawalstatepending
 */
class RevenueWithdrawalStatePending extends RevenueWithdrawalState
{
    /**
     * Type of the state, always “pending”
     */
    #[EnumOrScalar]
    public RevenueWithdrawalStateType|string $type = RevenueWithdrawalStateType::PENDING;
}
