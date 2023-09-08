<?php

namespace SergiX44\Nutgram\Telegram\Web;

use DateTime;

class LoginData extends Entity
{
    /**
     * Represents the identifier for a user.
     */
    public int $id;

    /**
     * The first name of a person.
     */
    public string $first_name;

    /**
     * The last name of a person.
     */
    public ?string $last_name = null;

    /**
     * The username of the user
     */
    public ?string $username = null;

    /**
     * The photo url of the user
     */
    public ?string $photo_url = null;

    /**
     * The date of authentication
     */
    public DateTime $auth_date;

    /**
     * The hash of the data
     */
    public string $hash;
}
