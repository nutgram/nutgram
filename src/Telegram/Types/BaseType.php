<?php

namespace SergiX44\Nutgram\Telegram\Types;

use Illuminate\Support\Traits\Macroable;
use SergiX44\Nutgram\Nutgram;

abstract class BaseType
{
    use Macroable;

    protected ?Nutgram $bot;

    public function __construct(?Nutgram $bot = null)
    {
        $this->bot = $bot;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        if (method_exists($this, 'jsonSerialize')) {
            return $this->jsonSerialize();
        }

        $public = new class {
            public function vars(mixed $obj)
            {
                return get_object_vars($obj);
            }
        };

        return array_filter($public->vars($this));
    }
}
