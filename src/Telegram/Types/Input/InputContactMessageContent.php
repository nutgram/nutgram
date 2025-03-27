<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Input;

use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content} of a contact message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputcontactmessagecontent
 */
class InputContactMessageContent extends InputMessageContent
{
    /** Contact's phone number */
    public string $phone_number;

    /** Contact's first name */
    public string $first_name;

    /**
     * Optional.
     * Contact's last name
     */
    public ?string $last_name = null;

    /**
     * Optional.
     * Additional data about the contact in the form of a {@see https://en.wikipedia.org/wiki/VCard vCard}, 0-2048 bytes
     */
    public ?string $vcard = null;

    public static function make(
        string $phone_number,
        string $first_name,
        ?string $last_name = null,
        ?string $vcard = null,
    ): self {
        $instance = new self;
        $instance->phone_number = $phone_number;
        $instance->first_name = $first_name;
        $instance->last_name = $last_name;
        $instance->vcard = $vcard;

        return $instance;
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'phone_number' => $this->phone_number,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'vcard' => $this->vcard,
        ]);
    }
}
