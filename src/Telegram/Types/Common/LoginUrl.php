<?php

namespace SergiX44\Nutgram\Telegram\Types\Common;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a parameter of the inline keyboard button used to automatically authorize a user.
 * Serves as a great replacement for the Telegram Login Widget when the user is coming from Telegram.
 * All the user needs to do is tap/click a button and confirm that they want to log in: IMAGE
 * Telegram apps support these buttons as of version 5.7.
 * Sample bot: [at]discussbot
 * @see https://core.telegram.org/file/811140015/1734/8VZFkwWXalM.97872/6127fa62d8a0bf2b3c IMAGE
 * @see https://t.me/discussbot [at]discussbot
 * @see https://core.telegram.org/bots/api#loginurl
 */
class LoginUrl extends BaseType
{
    /**
     * An HTTP URL to be opened with user authorization data added to the query string when the button is
     * pressed. If the user refuses to provide authorization data, the original URL without information about the
     * user will be opened. The data added is the same as described in Receiving authorization data.
     *
     * NOTE: You must always check the hash of the received data to verify the authentication
     * and the integrity of the data as described in Checking authorization.
     * @see https://core.telegram.org/widgets/login#receiving-authorization-data Receiving authorization data
     * @see https://core.telegram.org/widgets/login#checking-authorization Checking authorization
     */
    public string $url;

    /**
     * Optional. New text of the button in forwarded messages.
     */
    public ?string $forward_text = null;

    /**
     * Optional. Username of a bot, which will be used for user authorization.
     * See Setting up a bot for more details.
     * If not specified, the current bot's username will be assumed.
     * The url's domain must be the same as the domain linked with the bot.
     * See Linking your domain to the bot for more details.
     * @see https://core.telegram.org/widgets/login#setting-up-a-bot Setting up a bot
     * @see https://core.telegram.org/widgets/login#linking-your-domain-to-the-bot Linking your domain to the bot
     */
    public ?string $bot_username = null;

    /**
     * Optional. Pass True to request the permission for your bot to send messages to the user.
     */
    public ?bool $request_write_access = null;
}
