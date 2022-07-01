<?php

namespace SergiX44\Nutgram\Laravel\Mixins;

use Illuminate\Support\Facades\Storage;
use Psr\Http\Client\ClientInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Media\File;

/**
 * @mixin Nutgram
 */
class FileMixin
{
    /**
     * @return \Closure
     */
    public function saveToDisk()
    {
        return function (string $path, string $disk = null, array $clientOpt = []): bool {
            /** @var File $this */

            if (is_dir($path)) {
                $path = rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
                $path .= basename($this->file_path);
            }

            $savedPath = Storage::disk($disk)->path($path);

            if ($this->getConfig()['is_local'] ?? false) {
                return copy($this->downloadUrl($this), $savedPath);
            }

            $http = $this->getContainer()->get(ClientInterface::class);
            $http->get($this->downloadUrl($this), array_merge(['sink' => $savedPath], $clientOpt));

            return true;
        };
    }
}
