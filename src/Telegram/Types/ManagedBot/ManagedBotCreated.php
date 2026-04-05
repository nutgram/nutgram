<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\ManagedBot;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object contains information about the bot that was created to be managed by the current bot.
 * @see https://core.telegram.org/bots/api#managedbotcreated
 */
class ManagedBotCreated extends BaseType
{
    /**
     * Information about the bot.
     * The bot's token can be fetched using the method
     * {@see https://core.telegram.org/bots/api#getmanagedbottoken getManagedBotToken}.
     */
    public User $bot;
}
