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
    public ?string $last_name;

    /**
     * The username of the user
     */
    public ?string $username;

    /**
     * The photo url of the user
     */
    public ?string $photo_url;

    /**
     * The date of authentication
     */
    public DateTime $auth_date;

    /**
     * The hash of the data
     */
    public string $hash;

    protected function cast(): array
    {
        return [
            'id' => 'int',
            'auth_date' => 'datetime',
        ];
    }
}
