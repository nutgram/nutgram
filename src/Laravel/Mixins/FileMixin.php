<?php

namespace SergiX44\Nutgram\Laravel\Mixins;

use Closure;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Media\File;

/**
 * @mixin Nutgram
 */
class FileMixin
{
    /**
     * @return Closure
     */
    public function saveToDisk(): Closure
    {
        return function (string $path, ?string $disk = null, array $clientOpt = []): bool {
            /** @var File $this */

            return MixinUtils::saveFileToDisk($this, $path, $disk, $clientOpt);
        };
    }
}
