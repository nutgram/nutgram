<?php

declare(strict_types=1);

use SergiX44\Nutgram\Configuration;

it('allows extra parameters', function () {
    $config = new Configuration(extra: ['abc' => 123]);

    expect($config->abc)->toBe(123);
});
