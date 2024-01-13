<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use JsonSerializable;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\PassportSource;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents an error in the Telegram Passport element which was submitted that should be resolved by the user. It should be one of:
 * - {@see PassportElementErrorDataField PassportElementErrorDataField}
 * - {@see PassportElementErrorFrontSide PassportElementErrorFrontSide}
 * - {@see PassportElementErrorReverseSide PassportElementErrorReverseSide}
 * - {@see PassportElementErrorSelfie PassportElementErrorSelfie}
 * - {@see PassportElementErrorFile PassportElementErrorFile}
 * - {@see PassportElementErrorFiles PassportElementErrorFiles}
 * - {@see PassportElementErrorTranslationFile PassportElementErrorTranslationFile}
 * - {@see PassportElementErrorTranslationFiles PassportElementErrorTranslationFiles}
 * - {@see PassportElementErrorUnspecified PassportElementErrorUnspecified}
 * @see https://core.telegram.org/bots/api#passportelementerror
 */
abstract class PassportElementError extends BaseType implements JsonSerializable
{
    /** Error source */
    #[EnumOrScalar]
    public PassportSource|string $source;
}
