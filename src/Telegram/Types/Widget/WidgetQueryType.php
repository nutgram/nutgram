<?php

namespace SergiX44\Nutgram\Telegram\Types\Widget;

/**
 * This object describes the type of a query from a widget. Currently, it can be one of
 * - {@see WidgetQueryTypeData}
 * - {@see WidgetQueryTypeSignData}
 * - {@see WidgetQueryTypeSentTransaction}
 */
#[WidgetQueryTypeResolver]
interface WidgetQueryType
{
}
