<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;

/**
 * A block quotation, corresponding to the HTML tag &lt;blockquote&gt; with custom attribute "collapsed".
 * @see https://core.telegram.org/bots/api#inputrichblockexpandableblockquotation
 */
#[SkipConstructor]
class InputRichBlockExpandableBlockQuotation extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “expandable_blockquote”
     */
    public InputRichBlockType|string $type = InputRichBlockType::EXPANDABLE_BLOCKQUOTE;

    /**
     * Optional. Credit of the block
     * @var string|RichText[]|RichText|null
     */
    public string|array|RichText $text;

    /**
     * Optional. Credit of the block
     * @var string|RichText[]|RichText|null
     */
    public string|array|RichText|null $credit = null;

    /**
     * @param string|array|RichText|RichText[] $text
     * @param string|array|RichText|RichText[]|null $credit
     */
    public function __construct(string|array|RichText $text, string|array|RichText|null $credit = null)
    {
        $this->text = $text;
        $this->credit = $credit;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
