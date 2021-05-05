<?php


namespace SergiX44\Nutgram\Telegram\Endpoints;

use JsonException;
use SergiX44\Nutgram\Telegram\Client;

/**
 * Trait Passport
 * @package SergiX44\Nutgram\Telegram\Endpoints
 * @mixin Client
 */
trait Passport
{
    /**
     * Informs a user that some of the Telegram Passport elements they provided contains errors.
     * The user will not be able to re-submit their Passport to you until the errors are fixed
     * (the contents of the field for which you returned the error must change). Returns True on success.
     *
     * Use this if the data submitted by the user doesn't satisfy the standards your service requires for any reason.
     * For example, if a birthday date seems invalid, a submitted document is blurry,
     * a scan shows evidence of tampering, etc.
     * Supply some details in the error message to make sure the user knows how to correct the issues.
     * @see https://core.telegram.org/bots/api#setpassportdataerrors
     * @param  int  $user_id User identifier
     * @param  array  $errors An array describing the errors
     * @return bool|null
     * @throws JsonException
     */
    public function setPassportDataErrors(int $user_id, array $errors): ?bool
    {
        return $this->requestJson(__FUNCTION__, [
            'user_id' => $user_id,
            'errors' => json_encode($errors, JSON_THROW_ON_ERROR),
        ]);
    }
}
