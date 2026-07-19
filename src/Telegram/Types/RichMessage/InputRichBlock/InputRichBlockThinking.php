<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;

/**
 * A block with a “Thinking…” placeholder, corresponding to the custom HTML tag <code><tg-thinking></code>.
 * The block may be used only in {@see https://core.telegram.org/bots/api#sendrichmessagedraft sendRichMessageDraft},
 * therefore it can't be received in messages.
 * See https://t.me/addemoji/AIActions for examples of custom emoji that are recommended for usage in the block.
 * @see https://core.telegram.org/bots/api#inputrichblockthinking
 */
#[SkipConstructor]
class InputRichBlockThinking extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “thinking”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::THINKING;

    /**
     * Text of the block.
     * See https://t.me/addemoji/AIActions for examples of custom emoji that are recommended for usage in the block.
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
