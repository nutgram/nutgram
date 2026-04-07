<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes a keyboard button to be used by a user of a Mini App.
 * @see https://core.telegram.org/bots/api#preparedkeyboardbutton
 */
#[OverrideConstructor('bindToInstance')]
class PreparedKeyboardButton extends BaseType
{
    /**
     * @var string Unique identifier of the keyboard button
     */
    public string $id;

    public function __construct(string $id)
    {
        parent::__construct();
        $this->id = $id;
    }
}
