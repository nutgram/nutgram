<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\MenuButtonType;

#[Attribute(Attribute::TARGET_CLASS)]
class MenuButtonResolver extends ConcreteResolver
{
    protected array $concretes = [
        MenuButtonType::COMMANDS->value => MenuButtonCommands::class,
        MenuButtonType::DEFAULT->value => MenuButtonDefault::class,
        MenuButtonType::WEB_APP->value => MenuButtonWebApp::class,
    ];

    public function concreteFor(array $data): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ??  (new class extends MenuButton {
        })::class;
    }
}
