<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Contains a list of Telegram Star transactions.
 * @see https://core.telegram.org/bots/api#startransactions
 */
class StarTransactions extends BaseType
{
    /**
     * The list of transactions
     * @var StarTransaction[] $transactions
     */
    #[ArrayType(StarTransaction::class)]
    public array $transactions;
}
