<?php

namespace SergiX44\Nutgram\Telegram\Types\Widget;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\WidgetQueryTypeType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Payment\TonWalletCard;

/**
 * The query contains data for the bot.
 * @see https://core.telegram.org/bots/api#widgetquerytypedata
 */
class WidgetQueryTypeData extends BaseType implements WidgetQueryType
{
    /**
     * Type of the query, always “data”
     */
    #[EnumOrScalar]
    public WidgetQueryTypeType|string $type = WidgetQueryTypeType::DATA;

    /**
     * Optional. TON wallet card of the user who sent the query, if it was sent to the bot along with the query
     */
    public ?TonWalletCard $wallet_card = null;
}
