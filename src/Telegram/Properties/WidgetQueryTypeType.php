<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum WidgetQueryTypeType: string
{
    case DATA = 'data';
    case SIGN_DATA = 'sign_data';
    case SENT_TRANSACTION = 'sent_transaction';
}
