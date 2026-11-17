<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\TransactionPartnerType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * Describes a transaction with an unknown source or recipient.
 * @see https://core.telegram.org/bots/api#transactionpartnerother
 */
class TransactionPartnerOther extends BaseType implements TransactionPartner
{
    /**
     * Type of the transaction partner, always “other”
     */
    #[EnumOrScalar]
    public TransactionPartnerType|string $type = TransactionPartnerType::OTHER;
}
