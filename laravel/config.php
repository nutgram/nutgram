<?php

return [
    // The Telegram BOT api token
    'token' => env('TELEGRAM_TOKEN'),

    // if the webhook mode must validate the incoming IP range is from a telegram server
    'safe-mode' => env('APP_ENV', 'local') === 'production',

    // Extra or specific configurations
    'config' => [],

    // Set if the service provider should automatically load
    // handlers from /routes/telegram.php
    'routes' => true,
];
