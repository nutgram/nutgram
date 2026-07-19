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
 * A quotation with centered text, loosely corresponding to the HTML tag <code><aside></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockpullquotation
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockPullQuotation extends BaseType implements InputRichBlock
{
    /**
     * Type of the block, always “pullquote”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::PULLQUOTE;

    /**
     * Text of the block
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[TestUnionResolver('string')]
    public string|array|RichText $text;

    /**
     * Optional. Credit of the block
     * @var string|RichText[]|RichText|null
     */
    #[ArrayType(RichText::class)]
    #[TestUnionResolver('string')]
    public string|array|RichText|null $credit = null;

    public function __construct(string|array|RichText $text, string|array|RichText|null $credit = null)
    {
        parent::__construct();
        $this->text = $text;
        $this->credit = $credit;
    }
}
