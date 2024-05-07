<?php

namespace SergiX44\Nutgram\Telegram\Types\Poll;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * This object contains information about one answer option in a poll to send.
 * @see https://core.telegram.org/bots/api#inputpolloption
 */
class InputPollOption extends BaseType
{
    /** Option text, 1-100 characters */
    public string $text;

    /**
     * Optional. Mode for parsing entities in the option text.
     * See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * Currently, only custom emoji entities are allowed
     */
    #[EnumOrScalar]
    public ParseMode|string|null $text_parse_mode = null;

    /**
     * Optional. Special entities that appear in the option text. Currently, only custom emoji entities are allowed in poll option texts
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $text_entities = null;
}
