<?php

namespace SergiX44\Nutgram\Telegram\Types\Business;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Sticker\Sticker;

/**
 * @see https://core.telegram.org/bots/api#businessintro
 */
class BusinessIntro extends BaseType
{
    /**
     * Optional. Title text of the business intro
     */
    public ?string $title = null;

    /**
     * Optional. Message text of the business intro
     */
    public ?string $message = null;

    /**
     * Optional. Sticker of the business intro
     */
    public ?Sticker $sticker = null;
}
