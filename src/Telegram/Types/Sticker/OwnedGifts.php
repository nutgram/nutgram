<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

class OwnedGifts extends BaseType
{
    /**
     * The total number of gifts owned by the user or the chat
     */
    public int $total_count;

    /**
     * The list of gifts
     * @var OwnedGift[]
     */
    #[ArrayType(OwnedGift::class)]
    public array $gifts;

    /**
     * Optional. Offset for the next request. If empty, then there are no more results
     */
    public string $next_offset;
}
