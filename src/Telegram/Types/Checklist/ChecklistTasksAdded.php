<?php

namespace SergiX44\Nutgram\Telegram\Types\Checklist;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

class ChecklistTasksAdded extends BaseType
{
    /**
     * Optional. Message containing the checklist to which the tasks were added.
     * Note that the Message object in this field will not contain the reply_to_message field even if it itself is a reply.
     */
    public ?Message $checklist_message = null;

    /**
     * List of tasks added to the checklist
     * @var ChecklistTask[]
     */
    #[ArrayType(ChecklistTask::class)]
    public array $tasks;
}
