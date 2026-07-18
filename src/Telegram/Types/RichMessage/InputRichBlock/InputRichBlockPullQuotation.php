<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;

/**
 * A quotation with centered text, loosely corresponding to the HTML tag <code><aside></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockpullquotation
 */
#[SkipConstructor]
class InputRichBlockPullQuotation extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “pullquote”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::PULLQUOTE;

    /**
     * Text of the block
     */
    public RichText $text;

    /**
     * Optional. Credit of the block
     */
    public ?RichText $credit = null;

    public function __construct(RichText $text, ?RichText $credit = null)
    {
        parent::__construct();
        $this->text = $text;
        $this->credit = $credit;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
