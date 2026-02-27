<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\MenuButtonType;
use SergiX44\Nutgram\Telegram\Types\Command\MenuButton;
use SergiX44\Nutgram\Telegram\Types\Command\MenuButtonCommands;
use SergiX44\Nutgram\Telegram\Types\Command\MenuButtonDefault;
use SergiX44\Nutgram\Telegram\Types\Command\MenuButtonWebApp;

#[Attribute(Attribute::TARGET_CLASS)]
class MenuButtonResolver extends ConcreteResolver
{
    protected array $concretes = [
        MenuButtonType::COMMANDS->value => MenuButtonCommands::class,
        MenuButtonType::DEFAULT->value => MenuButtonDefault::class,
        MenuButtonType::WEB_APP->value => MenuButtonWebApp::class,
    ];

    public function concreteFor(array $data, array $all): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ?? (new class extends MenuButton {
        })::class;
    }
}
