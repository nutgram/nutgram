<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum PollType: string
{
    case REGULAR = 'regular';
    case QUIZ = 'quiz';
}
