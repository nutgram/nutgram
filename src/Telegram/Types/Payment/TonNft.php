<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Sticker\UniqueGift;

/**
 * This object represents an NFT in the TON blockchain.
 * @see https://core.telegram.org/bots/api#tonnft
 */
class TonNft extends BaseType
{
    /**
     * Address of the NFT
     */
    public string $address;

    /**
     * Optional. Address of the collection to which the NFT belongs; omitted if unknown
     */
    public string $collection_address;

    /**
     * Index of the NFT among all NFTs from the collection as a decimal number
     */
    public string $index;

    /**
     * Name of the NFT
     */
    public string $name;

    /**
     * Description of the NFT
     */
    public string $description;

    /**
     * Optional. Attributes of the NFT
     * @var TonNftAttribute[]|null
     */
    #[ArrayType(TonNftAttribute::class)]
    public ?array $attributes = null;

    /**
     * Optional. The unique gift corresponding to the NFT
     */
    public ?UniqueGift $gift = null;
}
