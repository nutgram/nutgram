<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Contains data required for decrypting and authenticating
 * {@see https://core.telegram.org/bots/api#encryptedpassportelement EncryptedPassportElement}.
 * See the {@see https://core.telegram.org/passport#receiving-information Telegram Passport Documentation}
 * for a complete description of the data decryption and authentication processes.
 * @see https://core.telegram.org/bots/api#encryptedcredentials
 */
class EncryptedCredentials
{
    /**
     * Base64-encoded encrypted JSON-serialized data with unique user's payload, data hashes and secrets required for
     * {@see https://core.telegram.org/bots/api#encryptedpassportelement EncryptedPassportElement}
     * decryption and authentication
     * @var string
     */
    public string $data;
    
    /**
     * Base64-encoded data hash for data authentication
     * @var string
     */
    public string $hash;
    
    /**
     * Base64-encoded secret, encrypted with the bot's public RSA key, required for data decryption
     * @var string
     */
    public string $secret;
}
