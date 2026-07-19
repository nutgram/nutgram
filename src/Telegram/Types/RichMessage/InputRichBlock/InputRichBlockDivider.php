<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * A divider, corresponding to the HTML tag <code><hr/></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockdivider
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockDivider extends BaseType implements InputRichBlock
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
}
