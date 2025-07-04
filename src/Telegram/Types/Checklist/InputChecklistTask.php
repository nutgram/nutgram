<?php

namespace SergiX44\Nutgram\Telegram\Types\Checklist;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Describes a task to add to a checklist.
 * @see https://core.telegram.org/bots/api#inputchecklisttask
 */
class InputChecklistTask extends BaseType
{
    /**
     * Unique identifier of the task; must be positive and unique among all task identifiers currently present in the checklist
     */
    public int $id;

    /**
     * Text of the task; 1-100 characters after entities parsing
     */
    public string $text;

    /**
     * Optional. Mode for parsing entities in the text.
     * See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     */
    #[EnumOrScalar]
    public ParseMode|string|null $parse_mode = null;

    /**
     * Optional. Special entities that appear in the task text
     * @var MessageEntity[]|null
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $text_entities = null;

    /**
     * @param int $id
     * @param string $text
     * @param ParseMode|string|null $parse_mode
     * @param MessageEntity[]|null $text_entities
     */
    public function __construct(
        int $id,
        string $text,
        ParseMode|string|null $parse_mode = null,
        ?array $text_entities = null,
    ) {
        parent::__construct();
        $this->id = $id;
        $this->text = $text;
        $this->parse_mode = $parse_mode;
        $this->text_entities = $text_entities;
    }
}
