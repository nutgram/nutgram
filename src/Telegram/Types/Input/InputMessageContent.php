<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use JsonSerializable;
use SergiX44\Nutgram\Telegram\Types\BaseType;

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
abstract class InputMessageContent extends BaseType implements JsonSerializable
{
}
