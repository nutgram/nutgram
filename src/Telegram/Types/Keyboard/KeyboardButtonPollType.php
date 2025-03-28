<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * This object represents type of a poll, which is allowed to be created and sent when the corresponding button is pressed.
 * @see https://core.telegram.org/bots/api#keyboardbuttonpolltype
 */
#[OverrideConstructor('bindToInstance')]
class KeyboardButtonPollType extends BaseType implements JsonSerializable
{
    /**
     * Optional.
     * If quiz is passed, the user will be allowed to create only polls in the quiz mode.
     * If regular is passed, only regular polls will be allowed.
     * Otherwise, the user will be allowed to create a poll of any type.
     */
    public ?string $type = null;

    public function __construct(?string $type = null)
    {
        parent::__construct();
        $this->type = $type;
    }


    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
        ]);
    }
}
