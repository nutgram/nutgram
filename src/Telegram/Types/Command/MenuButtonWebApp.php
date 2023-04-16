<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Nutgram\Telegram\Attributes\MenuButtonType;
use SergiX44\Nutgram\Telegram\Types\WebApp\WebAppInfo;

/**
 * Represents a menu button, which launches a Web App.
 * @see https://core.telegram.org/bots/api#menubuttonwebapp
 */
class MenuButtonWebApp extends MenuButton
{
    /**
     * Type of the button, must be web_app
     */
    public string $type = MenuButtonType::WEB_APP;

    /**
     * Text on the button
     */
    public ?string $text = null;

    /**
     * Description of the Web App that will be launched when the user presses the button.
     * The Web App will be able to send an arbitrary message on behalf of the user using
     * the method {@see https://core.telegram.org/bots/api#answerwebappquery answerWebAppQuery}.
     */
    public ?WebAppInfo $web_app = null;
}
