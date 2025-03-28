<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\WebApp;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes a {@see https://core.telegram.org/bots/webapps Web App}.
 * @see https://core.telegram.org/bots/api#webappinfo
 */
#[OverrideConstructor('bindToInstance')]
class WebAppInfo extends BaseType
{
    /** An HTTPS URL of a Web App to be opened with additional data as specified in {@see https://core.telegram.org/bots/webapps#initializing-web-apps Initializing Web Apps} */
    public string $url;

    public function __construct(string $url)
    {
        parent::__construct();
        $this->url = $url;
    }
}
