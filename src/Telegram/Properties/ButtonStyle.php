<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum ButtonStyle: string
{
    case DANGER = 'danger';
    case SUCCESS = 'success';
    case PRIMARY = 'primary';
}
