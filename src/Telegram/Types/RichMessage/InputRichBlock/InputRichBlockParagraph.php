<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;

/**
 * A text paragraph, corresponding to the HTML tag <code><p></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockparagraph
 */
#[SkipConstructor]
class InputRichBlockParagraph extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “paragraph”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::PARAGRAPH;

    /**
     * Text of the block
     */
    public RichText $text;

    public function __construct(RichText $text)
    {
        parent::__construct();
        $this->text = $text;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
