<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Support\Progress;

use SergiX44\Container\Container;

interface Trigger
{
    public function handle(Progress $progress, Container $container): bool;
}
