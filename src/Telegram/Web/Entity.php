<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Web;

abstract class Entity
{
    public function toArray(): array
    {
        $data = get_object_vars($this);
        foreach ($data as $key => $value) {
            if (is_subclass_of($value, self::class)) {
                $data[$key] = $value->toArray();
            }
        }
        return $data;
    }
}
