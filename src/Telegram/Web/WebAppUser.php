<?php

namespace SergiX44\Nutgram\Telegram\Web;

class WebAppUser extends Entity
{
    /**
     * A unique identifier for the user or bot.
     * This number may have more than 32 significant bits and some programming languages
     * may have difficulty/silent defects in interpreting it.
     * It has at most 52 significant bits, so a 64-bit integer or a double-precision
     * float type is safe for storing this identifier.
     */
    public int $id;

    /**
     * Optional. True, if this user is a bot.
     * Returns in the {@see https://core.telegram.org/bots/webapps#webappinitdata receiver} field only.
     */
    public bool $is_bot = false;

    /**
     * First name of the user or bot.
     */
    public string $first_name;

    /**
     * Optional. Last name of the user or bot.
     */
    public ?string $last_name = null;

    /**
     * Optional. Username of the user or bot.
     */
    public ?string $username = null;

    /**
     * Optional. {@see https://en.wikipedia.org/wiki/IETF_language_tag IETF language tag} of the user's language.
     * Returns in user field only.
     */
    public ?string $language_code = null;

    /**
     * Optional. True, if this user is a Telegram Premium user
     */
    public bool $is_premium = false;

    /**
     * Optional. True, if this user added the bot to the attachment menu.
     * @var bool
     */
    public bool $added_to_attachment_menu = false;

    /**
     * Optional. True, if this user allowed the bot to message them.
     * @var bool
     */
    public bool $allows_write_to_pm = false;

    /**
     * Optional. URL of the user’s profile photo.
     * The photo can be in .jpeg or .svg formats.
     * Only returned for Web Apps launched from the attachment menu.
     */
    public ?string $photo_url = null;
}
