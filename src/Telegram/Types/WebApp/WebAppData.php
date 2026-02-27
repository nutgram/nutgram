<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\WebApp;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes data sent from a {@see https://core.telegram.org/bots/webapps Web App} to the bot.
 * @see https://core.telegram.org/bots/api#webappdata
 */
class WebAppData extends BaseType
{
    /**
     * The data.
     * Be aware that a bad client can send arbitrary data in this field.
     */
    public string $data;

    /**
     * Text of the web_app keyboard button from which the Web App was opened.
     * Be aware that a bad client can send arbitrary data in this field.
     */
    public string $button_text;
}
