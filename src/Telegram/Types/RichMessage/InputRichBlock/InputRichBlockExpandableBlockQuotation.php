<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\UnionResolvers\RichTextUnionResolver;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;

/**
 * A block quotation, corresponding to the HTML tag &lt;blockquote&gt; with custom attribute "collapsed".
 * @see https://core.telegram.org/bots/api#inputrichblockexpandableblockquotation
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockExpandableBlockQuotation extends BaseType implements InputRichBlock
{
    /**
     * Type of the block, always “expandable_blockquote”
     */
    #[EnumOrScalar]
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
    #[ArrayType(RichText::class, skipScalars: true)]
    #[RichTextUnionResolver]
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
}
