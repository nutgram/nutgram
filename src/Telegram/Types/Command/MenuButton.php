<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use JsonSerializable;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\MenuButtonType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes the bot's menu button in a private chat. It should be one of
 * - {@see MenuButtonCommands MenuButtonCommands}
 * - {@see MenuButtonWebApp MenuButtonWebApp}
 * - {@see MenuButtonDefault MenuButtonDefault}
 *
 * If a menu button other than {@see https://core.telegram.org/bots/api#menubuttondefault MenuButtonDefault} is set for a private chat, then it is applied in the chat.
 * Otherwise the default menu button is applied. By default, the menu button opens the list of bot commands.
 * @see https://core.telegram.org/bots/api#menubutton
 */
#[MenuButtonResolver]
abstract class MenuButton extends BaseType implements JsonSerializable
{
    #[EnumOrScalar]
    public MenuButtonType|string $type;

    public function getType(): MenuButtonType|string
    {
        return $this->type;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
        ];
    }
}
