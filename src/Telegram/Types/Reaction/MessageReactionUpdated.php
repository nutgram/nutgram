<?php

namespace SergiX44\Nutgram\Telegram\Types\Reaction;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object represents a change of a reaction on a message performed by a user.
 * @see https://core.telegram.org/bots/api#messagereactionupdated
 */
class MessageReactionUpdated extends BaseType
{
    /**
     * The chat containing the message the user reacted to
     * @var Chat
     */
    public Chat $chat;

    /**
     * Unique identifier of the message inside the chat
     * @var int
     */
    public int $message_id;

    /**
     * Optional. The user that changed the reaction, if the user isn't anonymous
     * @var ?User
     */
    public ?User $user = null;

    /**
     * Optional. The chat on behalf of which the reaction was changed, if the user is anonymous
     * @var ?Chat
     */
    public ?Chat $actor_chat = null;

    /**
     * Date of the change in Unix time
     * @var int
     */
    public int $date;

    /**
     * Previous list of reaction types that were set by the user
     * @var ReactionType[]
     */
    #[ArrayType(ReactionType::class)]
    public array $old_reaction;

    /**
     * New list of reaction types that have been set by the user
     * @var ReactionType[]
     */
    #[ArrayType(ReactionType::class)]
    public array $new_reaction;
}
