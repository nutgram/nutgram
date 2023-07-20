<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use JsonSerializable;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\WebApp\WebAppInfo;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * This object represents a button to be shown above inline query results.
 * You must use exactly one of the optional fields.
 * @see https://core.telegram.org/bots/api#inlinequeryresultsbutton
 */
class InlineQueryResultsButton extends BaseType implements JsonSerializable
{
    /** Label text on the button */
    public string $text;

    /**
     * Optional.
     * Description of the {@see https://core.telegram.org/bots/webapps Web App} that will be launched when the user presses the button.
     * The Web App will be able to switch back to the inline mode using the method {@see https://core.telegram.org/bots/webapps#initializing-web-apps switchInlineQuery} inside the Web App.
     */
    public ?WebAppInfo $web_app = null;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots/features#deep-linking Deep-linking} parameter for the /start message sent to the bot when a user presses the button.
     * 1-64 characters, only A-Z, a-z, 0-9, _ and - are allowed.Example: An inline bot that sends YouTube videos can ask the user to connect the bot to their YouTube account to adapt search results accordingly.
     * To do this, it displays a 'Connect your YouTube account' button above the results, or even before showing any.
     * The user presses the button, switches to a private chat with the bot and, in doing so, passes a start parameter that instructs the bot to return an OAuth link.
     * Once done, the bot can offer a {@see https://core.telegram.org/bots/api#inlinekeyboardmarkup switch_inline} button so that the user can easily return to the chat where they wanted to use the bot's inline capabilities.
     */
    public ?string $start_parameter = null;

    public function __construct(
        string $text,
        ?WebAppInfo $web_app = null,
        ?string $start_parameter = null,
    ) {
        parent::__construct();
        $this->text = $text;
        $this->web_app = $web_app;
        $this->start_parameter = $start_parameter;
    }

    public static function make(
        string $text,
        ?WebAppInfo $web_app = null,
        ?string $start_parameter = null,
    ): self {
        return new self(
            text: $text,
            web_app: $web_app,
            start_parameter: $start_parameter
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'text' => $this->text,
            'web_app' => $this->web_app,
            'start_parameter' => $this->start_parameter,
        ]);
    }
}
