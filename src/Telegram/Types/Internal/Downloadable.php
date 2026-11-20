<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal;

/**
 * @mixin BaseType
 */
trait Downloadable
{
    public function download(string $path, array $clientOpt = []): ?bool
    {
        return $this->getBot()->getFile($this->file_id)?->save($path, $clientOpt);
    }
}
