<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Types\Internal\Resolvers\ChatMemberResolver;

/**
 * This object contains information about one member of a chat.
 * Currently, the following 6 types of chat members are supported:
 * - {@see ChatMemberOwner ChatMemberOwner}
 * - {@see ChatMemberAdministrator ChatMemberAdministrator}
 * - {@see ChatMemberMember ChatMemberMember}
 * - {@see ChatMemberRestricted ChatMemberRestricted}
 * - {@see ChatMemberLeft ChatMemberLeft}
 * - {@see ChatMemberBanned ChatMemberBanned}
 * @see https://core.telegram.org/bots/api#chatmember
 */
#[ChatMemberResolver]
interface ChatMember
{
}
