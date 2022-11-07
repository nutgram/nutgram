<?php

namespace SergiX44\Nutgram\Telegram\Attributes;

class ChatMemberStatus extends BaseEnum
{
    public const CREATOR = 'creator';
    public const ADMINISTRATOR = 'administrator';
    public const MEMBER = 'member';
    public const RESTRICTED = 'restricted';
    public const LEFT = 'left';
    public const KICKED = 'kicked';
}
