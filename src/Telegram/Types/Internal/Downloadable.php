<?php

namespace SergiX44\Nutgram\Telegram\Types\Internal;

use SergiX44\Nutgram\Telegram\Types\BaseType;

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
