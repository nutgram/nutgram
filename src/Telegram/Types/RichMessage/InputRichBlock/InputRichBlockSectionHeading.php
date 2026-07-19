<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;

/**
 * A section heading, corresponding to the HTML tags
 * <code><h1></code>, <code><h2></code>, <code><h3></code>, <code><h4></code>, <code><h5></code>, or <code><h6></code>.
 * @see https://core.telegram.org/bots/api#inputrichblocksectionheading
 */
#[SkipConstructor]
class InputRichBlockSectionHeading extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “heading”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::HEADING;

    /**
     * Text of the block
     */
    public RichText $text;

    /**
     * Relative size of the text font; 1-6, 1 is the largest, 6 is the smallest
     */
    public int $size;

    public function __construct(RichText $text, int $size)
    {
        parent::__construct();
        $this->text = $text;
        $this->size = $size;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
