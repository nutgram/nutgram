<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;

/**
 * A block quotation, corresponding to the HTML tag <code><blockquote></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockblockquotation
 */
#[SkipConstructor]
class InputRichBlockBlockQuotation extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “blockquote”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::BLOCKQUOTE;

    /**
     * Content of the block
     * @var InputRichBlock[]
     */
    #[ArrayType(InputRichBlock::class)]
    public array $blocks;

    /**
     * Optional. Credit of the block
     */
    public ?RichText $credit = null;

    public function __construct(array $blocks, ?RichText $credit = null)
    {
        parent::__construct();
        $this->blocks = $blocks;
        $this->credit = $credit;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
