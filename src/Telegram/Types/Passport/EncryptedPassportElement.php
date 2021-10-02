<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

/**
 * Contains information about documents or other Telegram Passport elements shared with the bot by the user.
 * @see https://core.telegram.org/bots/api#encryptedpassportelement
 */
class EncryptedPassportElement
{
    /**
     * Element type. One of “personal_details”, “passport”, “driver_license”, “identity_card”, “internal_passport”,
     * “address”, “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration”,
     * “temporary_registration”, “phone_number”, “email”.
     */
    public string $type;

    /**
     * Optional. Base64-encoded encrypted Telegram Passport element data provided by the user, available for
     * “personal_details”, “passport”, “driver_license”, “identity_card”, “internal_passport” and “address” types.
     * Can be decrypted and verified using the accompanying
     * {@see https://core.telegram.org/bots/api#encryptedcredentials EncryptedCredentials}.
     */
    public ?string $data = null;

    /**
     * Optional. User's verified phone number, available only for “phone_number” type
     */
    public ?string $phone_number = null;

    /**
     * Optional. User's verified email address, available only for “email” type
     */
    public ?string $email = null;

    /**
     * Optional. Array of encrypted files with documents provided by the user, available for
     * “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration” and “temporary_registration”
     * types.
     * Files can be decrypted and verified using the accompanying
     * {@see https://core.telegram.org/bots/api#encryptedcredentials EncryptedCredentials}.
     * @var \SergiX44\Nutgram\Telegram\Types\Passport\PassportFile[] $files
     */
    public ?array $files = null;

    /**
     * Optional. Encrypted file with the front side of the document, provided by the user.
     * Available for “passport”, “driver_license”, “identity_card” and “internal_passport”.
     * The file can be decrypted and verified using the accompanying
     * {@see https://core.telegram.org/bots/api#encryptedcredentials EncryptedCredentials}.
     */
    public ?PassportFile $front_side = null;

    /**
     * Optional. Encrypted file with the reverse side of the document, provided by the user.
     * Available for “driver_license” and “identity_card”.
     * The file can be decrypted and verified using the accompanying
     * {@see https://core.telegram.org/bots/api#encryptedcredentials EncryptedCredentials}.
     */
    public ?PassportFile $reverse_side = null;

    /**
     * Optional. Encrypted file with the selfie of the user holding a document, provided by the user;
     * available for “passport”, “driver_license”, “identity_card” and “internal_passport”.
     * The file can be decrypted and verified using the accompanying
     * {@see https://core.telegram.org/bots/api#encryptedcredentials EncryptedCredentials}.
     */
    public ?PassportFile $selfie = null;

    /**
     * Optional. Array of encrypted files with translated versions of documents provided by the user.
     * Available if requested for “passport”, “driver_license”, “identity_card”, “internal_passport”, “utility_bill”,
     * “bank_statement”, “rental_agreement”, “passport_registration” and “temporary_registration” types.
     * Files can be decrypted and verified using the accompanying
     * {@see https://core.telegram.org/bots/api#encryptedcredentials EncryptedCredentials}.
     * @var \SergiX44\Nutgram\Telegram\Types\Passport\PassportFile[] $translation
     */
    public ?array $translation = null;

    /**
     * Base64-encoded element hash for using in
     * {@see https://core.telegram.org/bots/api#passportelementerrorunspecified PassportElementErrorUnspecified}
     */
    public string $hash;
}
