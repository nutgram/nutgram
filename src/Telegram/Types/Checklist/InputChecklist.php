<?php

namespace SergiX44\Nutgram\Telegram\Types\Checklist;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Describes a checklist to create.
 * @see https://core.telegram.org/bots/api#inputchecklist
 */
class InputChecklist extends BaseType
{
    /**
     * Title of the checklist; 1-255 characters after entities parsing
     */
    public string $title;

    /**
     * Optional. Mode for parsing entities in the text.
     * See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     */
    #[EnumOrScalar]
    public ParseMode|string|null $parse_mode = null;

    /**
     * Optional. Special entities that appear in the checklist title
     * @var MessageEntity[]|null
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $title_entities = null;

    /**
     * List of 1-30 tasks in the checklist
     * @var InputChecklistTask[]
     */
    #[ArrayType(InputChecklistTask::class)]
    public array $tasks;

    /**
     * Optional. Pass True if other users can add tasks to the checklist
     */
    public ?bool $others_can_add_tasks = null;

    /**
     * Optional. Pass True if other users can mark tasks as done or not done in the checklist
     */
    public ?bool $others_can_mark_tasks_as_done = null;

    /**
     * @param string $title
     * @param InputChecklistTask[] $tasks
     * @param ParseMode|string|null $parse_mode
     * @param MessageEntity[]|null $title_entities
     * @param bool|null $others_can_add_tasks
     * @param bool|null $others_can_mark_tasks_as_done
     */
    public function __construct(
        string $title,
        array $tasks,
        ParseMode|string|null $parse_mode = null,
        ?array $title_entities = null,
        ?bool $others_can_add_tasks = null,
        ?bool $others_can_mark_tasks_as_done = null
    ) {
        parent::__construct();
        $this->title = $title;
        $this->tasks = $tasks;
        $this->parse_mode = $parse_mode;
        $this->title_entities = $title_entities;
        $this->others_can_add_tasks = $others_can_add_tasks;
        $this->others_can_mark_tasks_as_done = $others_can_mark_tasks_as_done;
    }
}
