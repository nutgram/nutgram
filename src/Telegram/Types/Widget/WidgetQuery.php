<?php

namespace SergiX44\Nutgram\Telegram\Types\Widget;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ChatType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object represents an incoming query from a widget in a message sent by the bot or via the bot.
 * Use {@see https://core.telegram.org/bots/api#answerwidgetquery answerWidgetQuery} to answer the query.
 * Each user can send at most 5 queries per 5 seconds to the bot from all its widgets.
 * @see https://core.telegram.org/bots/api#widgetquery
 */
class WidgetQuery extends BaseType
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
     * Optional. Chat with the message containing the widget; omitted if the widget is in an inline message
     */
    public ?Chat $chat = null;

    /**
     * Optional. Identifier of the message containing the widget; omitted if the widget is in an inline message
     */
    public ?int $message_id = null;

    /**
     * Optional. Identifier of the inline message containing the widget
     */
    public ?string $inline_message_id = null;

    /**
     * Global identifier, uniquely corresponding to the chat to which the message with the widget was sent
     */
    public string $chat_instance;

    /**
     * Optional. For widgets in inline messages, type of the chat to which the message was sent.
     * Can be either “sender” for a private chat with the inline query sender, “private”, “group”, “supergroup”, or “channel”.
     */
    #[EnumOrScalar]
    public ChatType|string|null $chat_type = null;

    /**
     * Type of the query
     */
    public WidgetQueryType $type;

    /**
     * Data of the query, 1-64 bytes
     */
    public string $data;

    /**
     * Optional. Unique identifier of the shared widget, which sent the query; omitted if the widget isn't shared
     */
    public ?string $widget_id = null;
}
