<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\TransactionPartnerType;

/**
 * Describes a transaction with payment for {@see https://core.telegram.org/bots/api#paid-broadcasts paid broadcasting}.
 * @see https://core.telegram.org/bots/api#transactionpartnertelegramapi
 */
class TransactionPartnerTelegramApi extends TransactionPartner
{
    /**
     * Type of the transaction partner, always “telegram_api”.
     */
    #[EnumOrScalar]
    public TransactionPartnerType|string $type = TransactionPartnerType::TELEGRAM_API;

    /**
     * The number of successful requests that exceeded regular limits and were therefore billed
     */
    public int $request_count;
}
