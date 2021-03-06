<?php


namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;

/**
 * Trait Passport
 * @package SergiX44\Nutgram\Telegram\Endpoints
 * @mixin Client
 */
trait Passport
{
    /**
     * @param  int  $user_id
     * @param  array  $errors
     * @return bool|null
     */
    public function setPassportDataErrors(int $user_id, array $errors): ?bool
    {
        return $this->requestJson(__FUNCTION__, [
            'user_id' => $user_id,
            'errors' => json_encode($errors),
        ]);
    }
}
