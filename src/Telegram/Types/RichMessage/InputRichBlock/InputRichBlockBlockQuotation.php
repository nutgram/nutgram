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
 * A block quotation, corresponding to the HTML tag <code><blockquote></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockblockquotation
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockBlockQuotation extends BaseType implements InputRichBlock
{
    /**
     * Type of the block, always “blockquote”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::BLOCKQUOTE;

    /**
     * Content of the block
     * @var InputRichBlock[]
     */
    #[ArrayType(InputRichBlock::class)]
    public array $blocks;

    /**
     * Optional. Credit of the block
     * @var string|RichText[]|RichText|null
     */
    #[ArrayType(RichText::class)]
    #[TestUnionResolver('string')]
    public string|array|RichText|null $credit = null;

    public function __construct(array $blocks, string|array|RichText|null $credit = null)
    {
        parent::__construct();
        $this->blocks = $blocks;
        $this->credit = $credit;
    }
}
