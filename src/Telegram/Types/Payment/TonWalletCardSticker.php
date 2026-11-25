<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Nutgram\Telegram\Types\Common\AreaPosition;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * This object describes a sticker on a TON wallet card.
 * @see https://core.telegram.org/bots/api#tonwalletcardsticker
 */
class TonWalletCardSticker extends BaseType
{
    /**
     * Position of the sticker on the card
     */
    public AreaPosition $position;

    /**
     * The NFT shown as the sticker
     */
    public TonNft $nft;
}
