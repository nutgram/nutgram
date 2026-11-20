<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputMediaType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * Represents a general file to be sent.
 * @see https://core.telegram.org/bots/api#inputmediadocument
 */
#[OverrideConstructor('bindToInstance')]
class InputMediaLink extends BaseType implements InputPollOptionMedia
{
    /**
     * Type of the result, must be link
     */
    #[EnumOrScalar]
    public InputMediaType|string $type = InputMediaType::LINK;

    /**
     * HTTP URL of the link
     */
    public string $url;


    public function __construct(string $url)
    {
        parent::__construct();
        $this->url = $url;
    }
}
