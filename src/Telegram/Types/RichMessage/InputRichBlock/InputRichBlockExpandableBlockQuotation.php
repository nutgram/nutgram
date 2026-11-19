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
     * Optional. Credit of the block
     * @var string|RichText|array<mixed>
     */
    #[ArrayType(RichText::class, skipScalars: true)]
    #[RichTextUnionResolver]
    public string|array|RichText $text;

    /**
     * Optional. Credit of the block
     * @var string|RichText|array<mixed>|null
     */
    #[ArrayType(RichText::class, skipScalars: true)]
    #[RichTextUnionResolver]
    public string|array|RichText|null $credit = null;

    /**
     * @param string|RichText|array<mixed> $text
     * @param string|RichText|array<mixed>|null $credit
     */
    public function __construct(string|array|RichText $text, string|array|RichText|null $credit = null)
    {
        parent::__construct();
        $this->text = $text;
        $this->credit = $credit;
    }
}
