<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Contains information about Telegram Passport data shared with the bot by the user.
 * @see https://core.telegram.org/bots/api#passportdata
 */
class PassportData extends BaseType
{
    /**
     * Array with information about documents and other Telegram Passport elements that was shared with the bot
     * @var EncryptedPassportElement[]
     */
    #[ArrayType(EncryptedPassportElement::class)]
    public array $data;

    /**
     * Encrypted credentials required to decrypt the data
     */
    public EncryptedCredentials $credentials;
}
