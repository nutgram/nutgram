<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RevenueWithdrawalStateType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes the state of a revenue withdrawal operation.
 * Currently, it can be one of
 * - {@see RevenueWithdrawalStatePending}
 * - {@see RevenueWithdrawalStateSucceeded}
 * - {@see RevenueWithdrawalStateFailed}
 * @see https://core.telegram.org/bots/api#revenuewithdrawalstate
 */
#[RevenueWithdrawalStateResolver]
abstract class RevenueWithdrawalState extends BaseType
{
    /**
     * Type of the state, can be “pending”, “succeeded” or “failed”.
     */
    #[EnumOrScalar]
    public RevenueWithdrawalStateType|string $type;
}
