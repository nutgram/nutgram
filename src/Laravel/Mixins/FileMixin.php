<?php

namespace SergiX44\Nutgram\Laravel\Mixins;

use Illuminate\Http\File as LaravelFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

            $storage = Storage::disk($disk);

            if (Str::endsWith($path, ['/', '\\'])) {
                $path .= basename($this->file_path ?? $this->file_id);
            }

            if ($this->getConfig()['is_local'] ?? false) {
                return $storage->put($path, $this->downloadUrl($this));
            }

            //create temp file
            $tmpFile = tempnam(sys_get_temp_dir(), uniqid(strftime('%G-%m-%d')));

            //download file to temp file
            $http = $this->getContainer()->get(ClientInterface::class);
            $http->get($this->downloadUrl($this), array_merge(['sink' => $tmpFile], $clientOpt));

            //save temp file to disk
            return $storage->putFileAs('/', new LaravelFile($tmpFile), $path);
        };
    }
}
