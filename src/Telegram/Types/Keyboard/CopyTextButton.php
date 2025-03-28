<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents an inline keyboard button that copies specified text to the clipboard.
 * @see https://core.telegram.org/bots/api#copytextbutton
 */
#[OverrideConstructor('bindToInstance')]
class CopyTextButton extends BaseType
{
    /**
     * The text to be copied to the clipboard; 1-256 characters
     */
    public string $text;

    public function __construct(string $text)
    {
        parent::__construct();
        $this->text = $text;
    }

}
