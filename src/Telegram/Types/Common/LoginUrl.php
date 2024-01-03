<?php

namespace SergiX44\Nutgram\Telegram\Types\Common;

use JsonSerializable;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * This object represents a parameter of the inline keyboard button used to automatically authorize a user.
 * Serves as a great replacement for the {@see https://core.telegram.org/widgets/login Telegram Login Widget} when the user is coming from Telegram.
 * All the user needs to do is tap/click a button and confirm that they want to log in:
 * @see https://core.telegram.org/bots/api#loginurl
 */
class LoginUrl extends BaseType implements JsonSerializable
{
    /**
     * An HTTPS URL to be opened with user authorization data added to the query string when the button is pressed.
     * If the user refuses to provide authorization data, the original URL without information about the user will be opened.
     * The data added is the same as described in {@see https://core.telegram.org/widgets/login#receiving-authorization-data Receiving authorization data}.NOTE: You must always check the hash of the received data to verify the authentication and the integrity of the data as described in {@see https://core.telegram.org/widgets/login#checking-authorization Checking authorization}.
     */
    public string $url;

    /**
     * Optional.
     * New text of the button in forwarded messages.
     */
    public ?string $forward_text = null;

    /**
     * Optional.
     * Username of a bot, which will be used for user authorization.
     * See {@see https://core.telegram.org/widgets/login#setting-up-a-bot Setting up a bot} for more details.
     * If not specified, the current bot's username will be assumed.
     * The url's domain must be the same as the domain linked with the bot.
     * See {@see https://core.telegram.org/widgets/login#linking-your-domain-to-the-bot Linking your domain to the bot} for more details.
     */
    public ?string $bot_username = null;

    /**
     * Optional.
     * Pass True to request the permission for your bot to send messages to the user.
     */
    public ?bool $request_write_access = null;

    public function __construct(
        string $url,
        ?string $forward_text = null,
        ?string $bot_username = null,
        ?bool $request_write_access = null
    ) {
        parent::__construct();
        $this->url = $url;
        $this->forward_text = $forward_text;
        $this->bot_username = $bot_username;
        $this->request_write_access = $request_write_access;
    }

    public static function make(
        string $url,
        ?string $forward_text = null,
        ?string $bot_username = null,
        ?bool $request_write_access = null
    ): self {
        return new self(
            url: $url,
            forward_text: $forward_text,
            bot_username: $bot_username,
            request_write_access: $request_write_access
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'url' => $this->url,
            'forward_text' => $this->forward_text,
            'bot_username' => $this->bot_username,
            'request_write_access' => $this->request_write_access,
        ]);
    }
}
