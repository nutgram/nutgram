<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\ManagedBot;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object contains information about the creation or
 * token update of a bot that is managed by the current bot.
 * @see https://core.telegram.org/bots/api#managedbotupdated
 */
class ManagedBotUpdated extends BaseType
{
    /**
     * User that created the bot
     */
    public User $user;

    /**
     * Information about the bot.
     * Token of the bot can be fetched using the method
     * {@see https://core.telegram.org/bots/api#getmanagedbottoken getManagedBotToken}.
     */
    public User $bot;
}
