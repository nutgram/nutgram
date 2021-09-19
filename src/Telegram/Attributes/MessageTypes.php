<?php

namespace SergiX44\Nutgram\Telegram\Attributes;

use ReflectionClass;

class MessageTypes
{
    public const TEXT = 'text';
    public const AUDIO = 'audio';
    public const DOCUMENT = 'document';
    public const ANIMATION = 'animation';
    public const GAME = 'game';
    public const PHOTO = 'photo';
    public const STICKER = 'sticker';
    public const VIDEO = 'video';
    public const VOICE = 'voice';
    public const VIDEO_NOTE = 'video_note';
    public const CONTACT = 'contact';
    public const LOCATION = 'location';
    public const VENUE = 'venue';
    public const POLL = 'poll';
    public const DICE = 'dice';
    public const NEW_CHAT_MEMBERS = 'new_chat_members';
    public const LEFT_CHAT_MEMBER = 'left_chat_member';
    public const NEW_CHAT_TITLE = 'new_chat_title';
    public const NEW_CHAT_PHOTO = 'new_chat_photo';
    public const DELETE_CHAT_PHOTO = 'delete_chat_photo';
    public const GROUP_CHAT_CREATED = 'group_chat_created';
    public const SUPERGROUP_CHAT_CREATED = 'supergroup_chat_created';
    public const CHANNEL_CHAT_CREATED = 'channel_chat_created';
    public const MIGRATE_TO_CHAT_ID = 'migrate_to_chat_id';
    public const MIGRATE_FROM_CHAT_ID = 'migrate_from_chat_id';
    public const PINNED_MESSAGE = 'pinned_message';
    public const INVOICE = 'invoice';
    public const SUCCESSFUL_PAYMENT = 'successful_payment';

    /**
     * @return array
     */
    public static function all(): array
    {
        return (new ReflectionClass(__CLASS__))->getConstants();
    }
}
