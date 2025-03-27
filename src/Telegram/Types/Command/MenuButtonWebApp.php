<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\MenuButtonType;
use SergiX44\Nutgram\Telegram\Types\WebApp\WebAppInfo;

/**
 * Represents a menu button, which launches a {@see https://core.telegram.org/bots/webapps Web App}.
 * @see https://core.telegram.org/bots/api#menubuttonwebapp
 */
class MenuButtonWebApp extends MenuButton
{
    /** Type of the button, must be web_app */
    #[EnumOrScalar]
    public MenuButtonType|string $type = MenuButtonType::WEB_APP;

    /** Text on the button */
    public string $text;

    /**
     * Description of the Web App that will be launched when the user presses the button.
     * The Web App will be able to send an arbitrary message on behalf of the user using the method {@see https://core.telegram.org/bots/api#answerwebappquery answerWebAppQuery}.
     */
    public WebAppInfo $web_app;

    public function make(string $text, WebAppInfo $web_app): self {
        $instance = new self;
        $instance->text = $text;
        $instance->web_app = $web_app;

        return $instance;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'text' => $this->text,
            'web_app' => $this->web_app,
        ];
    }
}
