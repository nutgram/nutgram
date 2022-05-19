<?php

namespace SergiX44\Nutgram\DownloadMode;

use SergiX44\Nutgram\Nutgram;

class Local implements DownloadMode
{
    public function buildPath(Nutgram $bot, string $path): string
    {
        return $path;
    }

    public function downloadPath(Nutgram $bot, string $fromPath, string $toPath, array $opt = []): bool
    {
        return copy($fromPath, $toPath);
    }
}
