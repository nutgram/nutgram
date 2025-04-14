<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum StoryAreaTypeType: string
{
    case LOCATION = 'location';
    case SUGGESTED_REACTION = 'suggested_reaction';
    case LINK = 'link';
    case WEATHER = 'weather';
    case UNIQUE_GIFT = 'unique_gift';
}
