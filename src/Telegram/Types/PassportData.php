<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Contains information about Telegram Passport data shared with the bot by the user.
 * @see https://core.telegram.org/bots/api#passportdata
 */
class PassportData
{
    /**
     * Array with information about documents and other Telegram Passport elements that was shared with the bot
     * @var EncryptedPassportElement[]
     */
    public array $data;

    /**
     * Encrypted credentials required to decrypt the data
     * @var EncryptedCredentials
     */
    public EncryptedCredentials $credentials;
}
