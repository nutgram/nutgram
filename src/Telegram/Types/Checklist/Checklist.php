<?php

namespace SergiX44\Nutgram\Telegram\Types\Checklist;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Describes a checklist.
 * @see https://core.telegram.org/bots/api#checklist
 */
class Checklist extends BaseType
{
    /**
     * Title of the checklist
     */
    public string $title;

    /**
     * Optional. Special entities that appear in the checklist title
     * @var MessageEntity[]|null
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $title_entities = null;

    /**
     * List of tasks in the checklist
     * @var ChecklistTask[]
     */
    #[ArrayType(ChecklistTask::class)]
    public array $tasks;

    /**
     * Optional. True, if users other than the creator of the list can add tasks to the list
     */
    public ?bool $others_can_add_tasks = null;

    /**
     * Optional. True, if users other than the creator of the list can mark tasks as done or not done
     */
    public ?bool $others_can_mark_tasks_as_done = null;
}
