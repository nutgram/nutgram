<?php

namespace SergiX44\Nutgram\Web\Entities;

use DateTime;

readonly class WebAppData extends Entity
{
    /**
     * Optional. A unique identifier for the Web App session, required for sending messages
     * via the {@see https://core.telegram.org/bots/api#answerwebappquery answerWebAppQuery} method.
     */
    public ?string $query_id;

    /**
     * Optional. An object containing data about the current user.
     */
    public ?WebAppUser $user;

    /**
     * Optional. An object containing data about the chat partner of the
     * current user in the chat where the bot was launched via the attachment menu.
     * Returned only for private chats and only for Web Apps launched via the attachment menu.
     */
    public ?WebAppUser $receiver;

    /**
     * Optional. An object containing data about the chat where the bot was launched via the attachment menu.
     * Returned for supergroups, channels and group chats – only for Web Apps launched via the attachment menu.
     */
    public ?WebAppChat $chat;

    /**
     * Optional. Type of the chat from which the Web App was opened.
     * Can be either “sender” for a private chat with the user opening the link,
     * “private”, “group”, “supergroup”, or “channel”.
     * Returned only for Web Apps launched from direct links.
     */
    public ?string $chat_type;

    /**
     * Optional. Global identifier, uniquely corresponding to the chat from which the Web App was opened.
     * Returned only for Web Apps launched from a direct link.
     */
    public ?string $chat_instance;

    /**
     * Optional. The value of the startattach parameter,
     * passed {@see https://core.telegram.org/bots/webapps#adding-bots-to-the-attachment-menu via link}.
     * Only returned for Web Apps when launched from the attachment menu via link.
     *
     * The value of the `start_param` parameter will also be passed in the GET-parameter `tgWebAppStartParam`,
     * so the Web App can load the correct interface right away.
     */
    public ?string $start_param;

    /**
     * Optional. Time in seconds, after which a message can be sent
     * via the {@see https://core.telegram.org/bots/api#answerwebappquery answerWebAppQuery} method.
     */
    public ?int $can_send_after;

    /**
     * Unix time when the form was opened.
     */
    public DateTime $auth_date;

    /**
     * A hash of all passed parameters, which the bot server can use to
     * {@see https://core.telegram.org/bots/webapps#validating-data-received-via-the-web-app check their validity}.
     */
    public string $hash;

    protected function cast(): array
    {
        return [
            'user' => WebAppUser::class,
            'receiver' => WebAppUser::class,
            'chat' => WebAppChat::class,
            'can_send_after' => 'int',
            'auth_date' => 'datetime',
        ];
    }
}
