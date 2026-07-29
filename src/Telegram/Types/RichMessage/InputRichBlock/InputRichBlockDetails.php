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
 * An expandable block for details disclosure, corresponding to the HTML tag <code><details></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockdetails
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockDetails extends BaseType implements InputRichBlock
{
    /**
     * Type of the block, always “details”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::DETAILS;

    /**
     * Always shown summary of the block
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[TestUnionResolver('string')]
    public string|array|RichText $summary;

    /**
     * Content of the block
     * @var InputRichBlock[]
     */
    #[ArrayType(InputRichBlock::class)]
    public array $blocks;

    /**
     * Optional. Pass True if the content of the block is visible by default
     */
    public ?bool $is_open = null;

    public function __construct(string|array|RichText $summary, array $blocks, ?bool $is_open = null)
    {
        parent::__construct();
        $this->summary = $summary;
        $this->blocks = $blocks;
        $this->is_open = $is_open;
    }
}
