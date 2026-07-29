<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\UnionResolvers\TestUnionResolver;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;

/**
 * A block with a “Thinking…” placeholder, corresponding to the custom HTML tag <code><tg-thinking></code>.
 * The block may be used only in {@see https://core.telegram.org/bots/api#sendrichmessagedraft sendRichMessageDraft},
 * therefore it can't be received in messages.
 * See https://t.me/addemoji/AIActions for examples of custom emoji that are recommended for usage in the block.
 * @see https://core.telegram.org/bots/api#inputrichblockthinking
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockThinking extends BaseType implements InputRichBlock
{
    /**
     * Type of the block, always “thinking”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::THINKING;

    /**
     * Text of the block.
     * See https://t.me/addemoji/AIActions for examples of custom emoji that are recommended for usage in the block.
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[TestUnionResolver('string')]
    public string|array|RichText $text;

    public function __construct(string|array|RichText $text)
    {
        parent::__construct();
        $this->text = $text;
    }
}
