<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;

/**
 * A preformatted text block, corresponding to the nested HTML tags <code><pre></code> and <code><code></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockpreformatted
 */
#[SkipConstructor]
class InputRichBlockPreformatted extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “pre”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::PRE;

    /**
     * Text of the block
     */
    public RichText $text;

    /**
     * Optional. The programming language of the text
     */
    public ?string $language = null;

    public function __construct(RichText $text, ?string $language = null)
    {
        parent::__construct();
        $this->text = $text;
        $this->language = $language;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
