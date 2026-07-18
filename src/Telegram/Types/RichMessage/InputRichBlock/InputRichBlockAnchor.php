<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A block with an anchor, corresponding to the HTML tag <code><a></code> with the attribute <code>name</code>.
 * @see https://core.telegram.org/bots/api#inputrichblockanchor
 */
#[SkipConstructor]
class InputRichBlockAnchor extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “anchor”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::ANCHOR;

    /**
     * The name of the anchor
     */
    public string $name;

    public function __construct(string $name)
    {
        parent::__construct();
        $this->name = $name;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
