<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage;

use SergiX44\Nutgram\Telegram\Types\Input\InputMessageContent;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content}
 * of a rich message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputrichmessagecontent
 */
class InputRichMessageContent extends InputMessageContent
{
    /**
     * The message to be sent
     */
    public InputRichMessage $rich_message;

    public function jsonSerialize(): array
    {
        return [
            'rich_message' => $this->rich_message,
        ];
    }
}
