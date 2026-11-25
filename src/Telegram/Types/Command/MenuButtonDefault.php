<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\MenuButtonType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * Describes that no specific value for the menu button was set.
 * @see https://core.telegram.org/bots/api#menubuttondefault
 */
class MenuButtonDefault extends BaseType implements MenuButton
{
    /** Type of the button, must be default */
    #[EnumOrScalar]
    public MenuButtonType|string $type = MenuButtonType::DEFAULT;
}
