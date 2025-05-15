<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\Resolvers\InputMessageContentResolver;

/**
 * This object represents the content of a message to be sent as a result of an inline query.
 * Telegram clients currently support the following 5 types:
 * - {@see InputTextMessageContent InputTextMessageContent}
 * - {@see InputLocationMessageContent InputLocationMessageContent}
 * - {@see InputVenueMessageContent InputVenueMessageContent}
 * - {@see InputContactMessageContent InputContactMessageContent}
 * - {@see InputInvoiceMessageContent InputInvoiceMessageContent}
 * @see https://core.telegram.org/bots/api#inputmessagecontent
 */
#[InputMessageContentResolver]
abstract class InputMessageContent extends BaseType
{
}
