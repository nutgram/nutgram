<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use JsonSerializable;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * This object defines the criteria used to request a suitable user.
 * The identifier of the selected user will be shared with the bot when the corresponding button is pressed.
 * {@see https://core.telegram.org/bots/features#chat-and-user-selection More about requesting users »}
 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestusers
 */
class KeyboardButtonRequestUsers extends BaseType implements JsonSerializable
{
    /**
     * Signed 32-bit identifier of the request, which will be received back in the {@see https://core.telegram.org/bots/api#usersshared UsersShared} object.
     * Must be unique within the message
     */
    public int $request_id;

    /**
     * Optional.
     * Pass True to request a bot, pass False to request a regular user.
     * If not specified, no additional restrictions are applied.
     */
    public ?bool $user_is_bot = null;

    /**
     * Optional.
     * Pass True to request a premium user, pass False to request a non-premium user.
     * If not specified, no additional restrictions are applied.
     */
    public ?bool $user_is_premium = null;

    /**
     * Optional. The maximum number of users to be selected; 1-10. Defaults to 1.
     */
    public ?int $max_quantity = null;

    public function __construct(
        int $request_id,
        ?bool $user_is_bot = null,
        ?bool $user_is_premium = null,
        ?int $max_quantity = null
    ) {
        parent::__construct();
        $this->request_id = $request_id;
        $this->user_is_bot = $user_is_bot;
        $this->user_is_premium = $user_is_premium;
        $this->max_quantity = $max_quantity;
    }

    public static function make(
        int $request_id,
        ?bool $user_is_bot = null,
        ?bool $user_is_premium = null,
        ?int $max_quantity = null
    ): self {
        return new self(
            request_id: $request_id,
            user_is_bot: $user_is_bot,
            user_is_premium: $user_is_premium,
            max_quantity: $max_quantity
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'request_id' => $this->request_id,
            'user_is_bot' => $this->user_is_bot,
            'user_is_premium' => $this->user_is_premium,
            'max_quantity' => $this->max_quantity,
        ]);
    }
}
