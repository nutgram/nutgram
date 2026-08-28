<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
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
    public InputRichBlockType|string $type = InputRichBlockType::DETAILS;

    /**
     * Always shown summary of the block
     * @var string|RichText[]|RichText
     */
    public string|array|RichText $summary;

    /**
     * Content of the block
     * @var InputRichBlock[]
     */
    public array $blocks;

    /**
     * Optional. Pass True if the content of the block is visible by default
     */
    public ?bool $is_open = null;

    /**
     * @param string|RichText[]|RichText $summary
     * @param InputRichBlock[] $blocks
     * @param bool|null $is_open
     */
    public function __construct(string|array|RichText $summary, array $blocks, ?bool $is_open = null)
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
