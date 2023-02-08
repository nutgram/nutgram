<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;

#[Attribute(Attribute::TARGET_CLASS)]
class MenuButtonResolver extends ConcreteResolver
{
    protected array $concretes = [
        'commands' => MenuButtonCommands::class,
        'default' => MenuButtonDefault::class,
        'web_app' => MenuButtonWebApp::class,
    ];

    public function concreteFor(array $data): ?string
    {
        return $this->concretes[$data['type']] ?? throw new InvalidArgumentException('Unknown MenuButton type: '.$data['type']);
    }
}
