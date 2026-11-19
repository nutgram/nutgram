<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\BotCommandScopeType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * Represents the {@see https://core.telegram.org/bots/api#botcommandscope scope} of bot commands, covering all group and supergroup chat administrators.
 * @see https://core.telegram.org/bots/api#botcommandscopeallchatadministrators
 */
class BotCommandScopeAllChatAdministrators extends BaseType implements BotCommandScope
{
    /** Scope type, must be all_chat_administrators */
    #[EnumOrScalar]
    public BotCommandScopeType|string $type = BotCommandScopeType::ALL_CHAT_ADMINISTRATORS;
}
