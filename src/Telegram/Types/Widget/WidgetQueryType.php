<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Widget;

use SergiX44\Nutgram\Telegram\Types\Internal\Resolvers\WidgetQueryTypeResolver;

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
