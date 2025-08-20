<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum SuggestedPostInfoState: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case DECLINED = 'declined';
}
