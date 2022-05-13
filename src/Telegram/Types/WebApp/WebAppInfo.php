<?php

namespace SergiX44\Nutgram\Telegram\Types\WebApp;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Contains information about a {@see https://core.telegram.org/bots/webapps Web App}.
 * @see https://core.telegram.org/bots/api#webappinfo
 */
class WebAppInfo extends BaseType
{
    /**
     * An HTTPS URL of a Web App to be opened with additional data
     * as specified in {@see https://core.telegram.org/bots/webapps#initializing-web-apps Initializing Web Apps}
     */
    public ?string $url;

    /**
     * @param  string|null  $url
     */
    public function __construct(?string $url = null)
    {
        parent::__construct();
        $this->url = $url;
    }
}
