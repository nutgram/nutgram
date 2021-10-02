<?php

return [
    // The Telegram BOT api token
    'token' => env('TELEGRAM_TOKEN', ''),

    // Extra or specific configurations
    'config' => [],


    // Set if the service provider should automatically load
    // handlers from /routes/telegram.php
    'routes' => true,
];
