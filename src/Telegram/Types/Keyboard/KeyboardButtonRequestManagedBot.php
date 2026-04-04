<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object defines the parameters for the creation of a managed bot.
 * Information about the created bot will be shared with the bot using the
 * update managed_bot and a {@see https://core.telegram.org/bots/api#message Message}
 * with the field managed_bot_created.
 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestmanagedbot
 */
class KeyboardButtonRequestManagedBot extends BaseType
{
    /**
     * Signed 32-bit identifier of the request.
     * Must be unique within the message
     */
    public int $request_id;

    /**
     * Optional. Suggested name for the bot
     */
    public ?string $suggested_name = null;

    /**
     * Optional. Suggested username for the bot
     */
    public ?string $suggested_username = null;

    public function __construct(
        int $request_id,
        ?string $suggested_name = null,
        ?string $suggested_username = null
    ) {
        parent::__construct();
        $this->request_id = $request_id;
        $this->suggested_name = $suggested_name;
        $this->suggested_username = $suggested_username;
    }

    public static function make(
        int $request_id,
        ?string $suggested_name = null,
        ?string $suggested_username = null,
    ): self {
        return new self(
            request_id: $request_id,
            suggested_name: $suggested_name,
            suggested_username: $suggested_username,
        );
    }
}
