<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Conversations;

use Closure;
use Laravel\SerializableClosure\SerializableClosure;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\MessageType;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;

class Stepper
{
    protected array $conditions = [];

    public function addCondition(string $step, UpdateType|MessageType|Closure|null $condition = null): void
    {
        $closure = match (true) {
            $condition instanceof UpdateType => fn (Nutgram $bot) => $bot->update()?->getType() === $condition,
            $condition instanceof MessageType => fn (Nutgram $bot) => $bot->message()?->getType() === $condition,
            $condition instanceof Closure => fn (Nutgram $bot) => $condition($bot) === true,
            default => fn (Nutgram $bot) => true,
        };

        $this->conditions[$step] = new SerializableClosure($closure);
    }

    public function resolve(Nutgram $bot): ?string
    {
        foreach ($this->conditions as $step => $condition) {
            $condition = $condition->getClosure();

            if ($condition($bot)) {
                return $step;
            }
        }

        return null;
    }
}
