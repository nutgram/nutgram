<?php

namespace SergiX44\Nutgram\Telegram\Types\Widget;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes a TON wallet of the user, which is used in a query from a widget.
 * @see https://core.telegram.org/bots/api#widgetquerywallet
 */
class WidgetQueryWallet extends BaseType
{
    /**
     * Address of the wallet
     */
    public string $address;

    /**
     * Balance of the wallet, in the smallest units of the cryptocurrency, as a decimal number
     */
    public string $amount;

    /**
     * Optional. Hex-encoded public key of the wallet; omitted if unknown
     */
    public ?string $public_key = null;

    /**
     * Optional. Base64-encoded serialized StateInit of the wallet contract;
     * omitted if and only if public_key is omitted
     */
    public ?string $state_init = null;
}
