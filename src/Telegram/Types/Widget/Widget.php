<?php

namespace SergiX44\Nutgram\Telegram\Types\Widget;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes an {@see https://core.telegram.org/bots/widgets HTML widget}.
 * @see https://core.telegram.org/bots/api#widget
 */
class Widget extends BaseType
{
    /**
     * Optional. Unique identifier of the shared widget, which can be used to send the widget again
     * using the method {@see https://core.telegram.org/bots/api#sendsharedwidget sendSharedWidget};
     * omitted if the widget isn't shared
     */
    public ?string $id = null;

    /**
     * Optional. Width of the widget in logical pixels;
     * omitted if the widget must occupy the whole width of the message bubble
     */
    public ?int $width = null;

    /**
     * Optional. Height of the widget in logical pixels;
     * omitted if the height of the widget isn't fixed
     */
    public ?int $height = null;

    /**
     * HTML code of the widget
     */
    public string $html;

    /**
     * Optional. Public data of the widget, which is available wherever the widget is shown.
     * All messages with a shared widget have the same public data.
     */
    public ?string $public_data = null;

    /**
     * Optional. Data of the widget, which is specific to the message
     */
    public ?string $chat_data = null;
}
