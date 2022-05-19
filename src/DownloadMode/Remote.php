<?php

namespace SergiX44\Nutgram\DownloadMode;

use SergiX44\Nutgram\Nutgram;
use Symfony\Component\HttpFoundation\Response;

class Remote implements DownloadMode
{
    public function buildPath(Nutgram $bot, string $path): string
    {
        return sprintf(
            "%s/file/bot%s/%s",
            $bot->getConfig()['api_url'] ?? Nutgram::DEFAULT_API_URL,
            $bot->getToken(),
            $path
        );
    }

    public function downloadPath(Nutgram $bot, string $fromPath, string $toPath, array $opt = []): bool
    {
        $response = $bot->getHttp()->get($fromPath, array_merge(['sink' => $toPath], $opt['clientOpt'] ?? []));
        return $response->getStatusCode() === Response::HTTP_OK;
    }
}
