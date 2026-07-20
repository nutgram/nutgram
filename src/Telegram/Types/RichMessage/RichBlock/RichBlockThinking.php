<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextUnionResolver;

/**
 * A block with a “Thinking…” placeholder, corresponding to the custom HTML tag <code><tg-thinking></code>.
 * The block may be used only in {@see https://core.telegram.org/bots/api#sendrichmessagedraft sendRichMessageDraft}, therefore it can't be received in messages.
 * See https://t.me/addemoji/AIActions for examples of custom emoji, which are recommended for usage in the block.
 * @see https://core.telegram.org/bots/api#richblockanchor
 */
class RichBlockThinking extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “thinking”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::THINKING;

    /**
     * Text of the block.
     * See https://t.me/addemoji/AIActions for examples of custom emoji,
     * which are recommended for usage in the block.
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class, skipScalars: true)]
    #[RichTextUnionResolver]
    public string|array|RichText $text;
}
