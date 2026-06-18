<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Media;

use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * Represents an HTTP link.
 * @see https://core.telegram.org/bots/api#link
 */
class Link extends BaseType
{
    /**
     * URL of the link
     */
    public string $url;
}
