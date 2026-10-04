<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
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
    public InputRichBlockType|string $type = InputRichBlockType::PRE;

    /**
     * Text of the block
     * @var string|RichText|array<mixed>
     */
    public string|array|RichText $text;

    /**
     * Optional. The programming language of the text
     */
    public ?string $language = null;

    /**
     * @param string|RichText|array<mixed> $text
     * @param string|null $language
     */
    public function __construct(string|array|RichText $text, ?string $language = null)
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
