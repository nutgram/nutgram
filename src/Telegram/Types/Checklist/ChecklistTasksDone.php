<?php

namespace SergiX44\Nutgram\Telegram\Types\Checklist;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

/**
 * Describes a service message about checklist tasks marked as done or not done.
 * @see https://core.telegram.org/bots/api#checklisttasksdone
 */
class ChecklistTasksDone extends BaseType
{
    /**
     * Optional. Message containing the checklist whose tasks were marked as done or not done.
     * Note that the Message object in this field will not contain the reply_to_message field even if it itself is a reply.
     */
    public ?Message $checklist_message = null;

    /**
     * Optional. Identifiers of the tasks that were marked as done
     * @var int[]|null
     */
    public ?array $marked_as_done_task_ids = null;

    /**
     * Optional. Identifiers of the tasks that were marked as not done
     * @var int[]|null
     */
    public ?array $marked_as_not_done_task_ids = null;
}
