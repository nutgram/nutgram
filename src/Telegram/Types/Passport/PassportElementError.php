<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Passport;

/**
 * This object represents an error in the Telegram Passport element which was submitted that should be resolved by the user. It should be one of:
 * - {@see PassportElementErrorDataField}
 * - {@see PassportElementErrorFrontSide}
 * - {@see PassportElementErrorReverseSide}
 * - {@see PassportElementErrorSelfie}
 * - {@see PassportElementErrorFile}
 * - {@see PassportElementErrorFiles}
 * - {@see PassportElementErrorTranslationFile}
 * - {@see PassportElementErrorTranslationFiles}
 * - {@see PassportElementErrorUnspecified}
 * @see https://core.telegram.org/bots/api#passportelementerror
 */
interface PassportElementError
{
}
