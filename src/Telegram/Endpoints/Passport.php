<?php

namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Passport\PassportElementError;

/**
 * Trait Passport
 * @package SergiX44\Nutgram\Telegram\Endpoints
 * @mixin Client
 */
trait Passport
{
    /**
     * Informs a user that some of the Telegram Passport elements they provided contains errors.
     * The user will not be able to re-submit their Passport to you until the errors are fixed (the contents of the field for which you returned the error must change).
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setpassportdataerrors
     * @param int $user_id User identifier
     * @param PassportElementError[] $errors A JSON-serialized array describing the errors
     * @return bool|null
     */
    public function setPassportDataErrors(int $user_id, array $errors): ?bool
    {
        $parameters = compact('user_id', 'errors');
        $parameters['errors'] = json_encode($parameters['errors'], JSON_THROW_ON_ERROR);

        return $this->requestJson(__FUNCTION__, $parameters);
    }
}
