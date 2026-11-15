<?php

namespace SergiX44\Nutgram\Telegram\Types\Widget;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\WidgetQueryTypeType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * The query contains data signed by a TON wallet of the user who sent the query.
 * The data is signed for the domain bot<bot_id>, where <bot_id> is the identifier of the bot.
 * @see https://core.telegram.org/bots/api#widgetquerytypesigndata
 */
class WidgetQueryTypeSignData extends BaseType implements WidgetQueryType
{
    /**
     * Type of the query, always “sign_data”
     */
    #[EnumOrScalar]
    public WidgetQueryTypeType|string $type = WidgetQueryTypeType::SIGN_DATA;

    /**
     * The wallet that signed the data
     */
    public WidgetQueryWallet $wallet;

    /**
     * JSON-serialized signed data
     */
    public string $sign_data;
}
