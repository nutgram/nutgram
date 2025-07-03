<?php

namespace SergiX44\Nutgram\Telegram\Types\Checklist;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Describes a task in a checklist.
 * @see https://core.telegram.org/bots/api#checklisttask
 */
class ChecklistTask extends BaseType
{
    /**
     * Unique identifier of the task
     */
    public int $id;

    /**
     * Text of the task
     */
    public string $text;

    /**
     * Optional. Special entities that appear in the task text
     * @var MessageEntity[]|null
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $text_entities = null;

    /**
     * Optional. User that completed the task; omitted if the task wasn't completed
     */
    public ?User $completed_by_user = null;

    /**
     * Optional. Point in time (Unix timestamp) when the task was completed; 0 if the task wasn't completed
     */
    public ?int $completion_date = null;
}
