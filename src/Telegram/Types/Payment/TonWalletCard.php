<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes a TON wallet card, which is shown on the profile page of a user to everyone.
 * @see https://core.telegram.org/bots/api#tonwalletcard
 */
class TonWalletCard extends BaseType
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
     * Stickers placed on the card
     * @var TonWalletCardSticker[]
     */
    #[ArrayType(TonWalletCardSticker::class)]
    public array $stickers;

    /**
     * Optional.
     * Address of the NFT of one of the stickers, whose colors must be used for the card background;
     * omitted if the default background must be used
     */
    public ?string $background_nft_address = null;
}
