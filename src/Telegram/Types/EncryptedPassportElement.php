<?php

namespace SergiX44\Nutgram\Telegram\Types;

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
     * @var string $type
     */
    public $type;
    
    /**
     * Optional. Base64-encoded encrypted Telegram Passport element data provided by the user, available for
     * “personal_details”, “passport”, “driver_license”, “identity_card”, “internal_passport” and “address” types.
     * Can be decrypted and verified using the accompanying
     * {@see https://core.telegram.org/bots/api#encryptedcredentials EncryptedCredentials}.
     * @var string $data
     */
    public $data;
    
    /**
     * Optional. User's verified phone number, available only for “phone_number” type
     * @var string $phone_number
     */
    public $phone_number;
    
    /**
     * Optional. User's verified email address, available only for “email” type
     * @var string $email
     */
    public $email;
    
    /**
     * Optional. Array of encrypted files with documents provided by the user, available for
     * “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration” and “temporary_registration” types.
     * Files can be decrypted and verified using the accompanying {@see https://core.telegram.org/bots/api#encryptedcredentials EncryptedCredentials}.
     * @var PassportFile[] $files
     */
    public $files;
    
    /**
     * Optional. Encrypted file with the front side of the document, provided by the user.
     * Available for “passport”, “driver_license”, “identity_card” and “internal_passport”.
     * The file can be decrypted and verified using the accompanying
     * {@see https://core.telegram.org/bots/api#encryptedcredentials EncryptedCredentials}.
     * @var PassportFile $front_side
     */
    public $front_side;
    
    /**
     * Optional. Encrypted file with the reverse side of the document, provided by the user.
     * Available for “driver_license” and “identity_card”.
     * The file can be decrypted and verified using the accompanying
     * {@see https://core.telegram.org/bots/api#encryptedcredentials EncryptedCredentials}.
     * @var PassportFile $reverse_side
     */
    public $reverse_side;
    
    /**
     * Optional. Encrypted file with the selfie of the user holding a document, provided by the user;
     * available for “passport”, “driver_license”, “identity_card” and “internal_passport”.
     * The file can be decrypted and verified using the accompanying
     * {@see https://core.telegram.org/bots/api#encryptedcredentials EncryptedCredentials}.
     * @var PassportFile $selfie
     */
    public $selfie;
    
    /**
     * Optional. Array of encrypted files with translated versions of documents provided by the user.
     * Available if requested for “passport”, “driver_license”, “identity_card”, “internal_passport”, “utility_bill”,
     * “bank_statement”, “rental_agreement”, “passport_registration” and “temporary_registration” types.
     * Files can be decrypted and verified using the accompanying
     * {@see https://core.telegram.org/bots/api#encryptedcredentials EncryptedCredentials}.
     * @var PassportFile[] $translation
     */
    public $translation;
    
    /**
     * Base64-encoded element hash for using in
     * {@see https://core.telegram.org/bots/api#passportelementerrorunspecified PassportElementErrorUnspecified}
     * @var string $hash
     */
    public $hash;
}
