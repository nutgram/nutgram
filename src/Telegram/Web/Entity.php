<?php

namespace SergiX44\Nutgram\Telegram\Web;

abstract class Entity
{
    public function toArray(): array
    {
        $data = get_object_vars($this);
        foreach ($data as $key => $value) {
            if (is_subclass_of($value, __CLASS__)) {
                $data[$key] = $value->toArray();
            }
        }
        return $data;
    }
}
