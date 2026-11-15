<?php

namespace SergiX44\Nutgram\Telegram\Types\Widget;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object represents an incoming query from a forwarded message with a shared widget created by the bot.
 * Use {@see https://core.telegram.org/bots/api#answerwidgetquery answerWidgetQuery} to answer the query.
 * Each user can send at most 5 queries per 5 seconds to the bot from all its widgets.
 * @see https://core.telegram.org/bots/api#sharedwidgetquery
 */
class SharedWidgetQuery extends BaseType
{
    /**
     * Unique identifier for this query
     */
    public string $id;

    /**
     * Sender
     */
    public User $from;

    /**
     * Type of the query
     */
    public WidgetQueryType $type;

    /**
     * Data of the query, 1-64 bytes
     */
    public string $data;

    /**
     * Unique identifier of the shared widget, which sent the query
     */
    public string $widget_id;
}
