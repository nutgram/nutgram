<?php

namespace SergiX44\Nutgram\Telegram\Types\Internal;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * @mixin BaseType
 */
trait HasDownload
{
    public function download(string $path, array $clientOpt = []): ?bool
    {
        return $this->bot->getFile($this->file_id)?->save($path, $clientOpt);
    }
}
