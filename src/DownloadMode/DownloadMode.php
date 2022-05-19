<?php

namespace SergiX44\Nutgram\DownloadMode;

use SergiX44\Nutgram\Nutgram;

interface DownloadMode
{
    public function buildPath(Nutgram $bot, string $path): string;

    public function downloadPath(Nutgram $bot, string $fromPath, string $toPath, array $opt = []): bool;
}
