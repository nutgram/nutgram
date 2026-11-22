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
     * Content of the block
     * @var InputRichBlock[]
     */
    public array $blocks;

    /**
     * Optional. Credit of the block
     * @var string|RichText|array<mixed>|null
     */
    public string|array|RichText|null $credit = null;

    /**
     * @param InputRichBlock[] $blocks
     * @param string|RichText|array<mixed>|null $credit
     */
    public function __construct(array $blocks, string|array|RichText|null $credit = null)
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
