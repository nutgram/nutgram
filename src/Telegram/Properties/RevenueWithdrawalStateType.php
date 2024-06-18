<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum RevenueWithdrawalStateType: string
{
    case PENDING = 'pending';
    Case SUCCEEDED = 'succeeded';
    case FAILED = 'failed';
}
