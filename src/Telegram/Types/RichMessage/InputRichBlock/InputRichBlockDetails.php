<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;

/**
 * An expandable block for details disclosure, corresponding to the HTML tag <code><details></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockdetails
 */
#[SkipConstructor]
class InputRichBlockDetails extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “details”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::DETAILS;

    /**
     * Always shown summary of the block
     */
    public RichText $summary;

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

    public function __construct(RichText $summary, array $blocks, ?bool $is_open = null)
    {
        parent::__construct();
        $this->summary = $summary;
        $this->blocks = $blocks;
        $this->is_open = $is_open;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
