<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\User;

use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * This object represents a Telegram user or bot.
 * @see https://core.telegram.org/bots/api#user
 */
class User extends BaseType
{
    /**
     * Unique identifier for this user or bot.
     * This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier.
     */
    public int $id;

    /** True, if this user is a bot */
    public bool $is_bot;

    /** User's or bot's first name */
    public string $first_name;

    /**
     * Optional.
     * User's or bot's last name
     */
    public ?string $last_name = null;

    /**
     * Optional.
     * User's or bot's username
     */
    public ?string $username = null;

    /**
     * Optional.
     * {@see https://en.wikipedia.org/wiki/IETF_language_tag IETF language tag} of the user's language
     */
    public ?string $language_code = null;

    /**
     * Optional.
     * True, if this user is a Telegram Premium user
     */
    public ?bool $is_premium = null;

    /**
     * Optional.
     * True, if this user added the bot to the attachment menu
     */
    public ?bool $added_to_attachment_menu = null;

    public static function make(
        int $id,
        bool $is_bot,
        string $first_name,
        ?string $last_name = null,
        ?string $username = null,
        ?string $language_code = null,
        ?bool $is_premium = null,
        ?bool $added_to_attachment_menu = null,
    ): User {
        $user = new self();
        $user->id = $id;
        $user->is_bot = $is_bot;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->username = $username;
        $user->language_code = $language_code;
        $user->is_premium = $is_premium;
        $user->added_to_attachment_menu = $added_to_attachment_menu;
        return $user;
    }
}
