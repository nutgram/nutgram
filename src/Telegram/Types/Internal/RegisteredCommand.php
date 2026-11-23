<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal;

use BackedEnum;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommand;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScope;

class RegisteredCommand implements Arrayable
{
    public function __construct(
        public BotCommand $command,
        public ?string $language,
        public BotCommandScope $scope,
    ) {
    }

    public function toArray(): array
    {
        $data = get_object_vars($this);

        array_walk_recursive($data, static function (mixed &$value, string $key): void {
            match (true) {
                $value instanceof Arrayable => $value = $value->toArray(),
                $value instanceof BackedEnum => $value = $value->value,
                default => null,
            };
        });

        return $data;
    }
}
