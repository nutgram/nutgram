<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A divider, corresponding to the HTML tag <code><hr/></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockdivider
 */
#[SkipConstructor]
class InputRichBlockDivider extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “divider”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::DIVIDER;

    public function __construct()
    {
        parent::__construct();
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
