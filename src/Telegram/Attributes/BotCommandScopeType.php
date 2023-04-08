<?php

namespace SergiX44\Nutgram\Telegram\Attributes;

class BotCommandScopeType
{
    public const DEFAULT = 'default';
    public const ALL_PRIVATE_CHATS = 'all_private_chats';
    public const ALL_GROUP_CHATS = 'all_group_chats';
    public const ALL_CHAT_ADMINISTRATORS = 'all_chat_administrators';
    public const CHAT = 'chat';
    public const CHAT_ADMINISTRATORS = 'chat_administrators';
    public const CHAT_MEMBER = 'chat_member';
}
