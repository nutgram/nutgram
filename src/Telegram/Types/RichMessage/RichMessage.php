<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlock;

/**
 * Rich formatted message.
 * @see https://core.telegram.org/bots/api#richmessage
 */
class RichMessage extends BaseType
{
    /**
     * Content of the message
     * @var RichBlock[]
     */
    #[ArrayType(RichBlock::class)]
    public array $blocks;

    /**
     * Optional. True, if the rich message must be shown right-to-left
     */
    public ?bool $is_rtl = null;
}
