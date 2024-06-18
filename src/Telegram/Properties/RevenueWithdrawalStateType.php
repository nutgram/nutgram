<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum RevenueWithdrawalStateType: string
{
    case PENDING = 'pending';
    case SUCCEEDED = 'succeeded';
    case FAILED = 'failed';
}
