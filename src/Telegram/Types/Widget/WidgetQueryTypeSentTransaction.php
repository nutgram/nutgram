<?php

namespace SergiX44\Nutgram\Telegram\Types\Widget;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\WidgetQueryTypeType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * The query notifies the bot about a transaction sent from a TON wallet of the user who sent the query.
 * @see https://core.telegram.org/bots/api#widgetquerytypesenttransaction
 */
class WidgetQueryTypeSentTransaction extends BaseType implements WidgetQueryType
{
    /**
     * Type of the query, always “sent_transaction”
     */
    #[EnumOrScalar]
    public WidgetQueryTypeType|string $type = WidgetQueryTypeType::SENT_TRANSACTION;

    /**
     * The wallet from which the transaction was sent
     */
    public WidgetQueryWallet $wallet;

    /**
     * Value of msg_hash of the transaction
     */
    public string $msg_hash;
}
