<?php

namespace SergiX44\Nutgram\Telegram\Types\WebApp;

use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes a {@see https://core.telegram.org/bots/webapps Web App}.
 * @see https://core.telegram.org/bots/api#webappinfo
 */
#[SkipConstructor]
class WebAppInfo extends BaseType
{
    /** An HTTPS URL of a Web App to be opened with additional data as specified in {@see https://core.telegram.org/bots/webapps#initializing-web-apps Initializing Web Apps} */
    public string $url;

    public function __construct(string $url)
    {
        parent::__construct();
        $this->url = $url;
    }

    public static function make(string $url): self
    {
        return new self($url);
    }
}
