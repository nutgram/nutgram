<?php

namespace SergiX44\Nutgram\Laravel\Mixins;

use Closure;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Media\File;

class NutgramMixin
{
    /**
     * @return Closure
     */
    public function downloadFileToDisk(): Closure
    {
        return function (File $file, string $path, ?string $disk = null, array $clientOpt = []): bool {
            /** @var Nutgram $this */

            return MixinUtils::saveFileToDisk($file, $path, $disk, $clientOpt);
        };
    }
}
