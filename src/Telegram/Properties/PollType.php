<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum PollType: string
{
    case REGULAR = 'regular';
    case QUIZ = 'quiz';
}
