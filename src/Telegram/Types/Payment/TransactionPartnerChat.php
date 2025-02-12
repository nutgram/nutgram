<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\TransactionPartnerType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;

/**
 * Describes a transaction with a chat.
 * @see https://core.telegram.org/bots/api#transactionpartnerchat
 */
class TransactionPartnerChat extends TransactionPartner
{
    /**
     * Type of the transaction partner, always “chat”
     */
    #[EnumOrScalar]
    public TransactionPartnerType|string $type = TransactionPartnerType::CHAT;

    /**
     * Information about the chat
     */
    public Chat $chat;

    /**
     * Optional. The gift sent to the user by the bot
     */
    public ?string $gift = null;
}
