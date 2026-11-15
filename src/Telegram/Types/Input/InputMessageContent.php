<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\Resolvers\InputMessageContentResolver;

/**
 * This object represents the content of a message to be sent as a result of an inline query.
 * Telegram clients currently support the following 5 types:
 * - {@see InputTextMessageContent}
 * - {@see InputRichMessageContent}
 * - {@see InputLocationMessageContent}
 * - {@see InputVenueMessageContent}
 * - {@see InputContactMessageContent}
 * - {@see InputInvoiceMessageContent}
 * - {@see InputWidgetMessageContent}
 * - {@see InputSharedWidgetMessageContent}
 * @see https://core.telegram.org/bots/api#inputmessagecontent
 */
#[InputMessageContentResolver]
abstract class InputMessageContent extends BaseType
{
}
