<?php

namespace SergiX44\Nutgram\Laravel\Mixins;

use Illuminate\Http\File as LaravelFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Psr\Http\Client\ClientInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Media\File;

class NutgramMixin
{
    /**
     * @return \Closure
     */
    public function downloadFileToDisk()
    {
        return function (File $file, string $path, string $disk = null, array $clientOpt = []): bool {
            /** @var Nutgram $this */

            $storage = Storage::disk($disk);

            if (Str::endsWith($path, ['/', '\\'])) {
                $path .= basename($file->file_path ?? $file->file_id);
            }

            if ($this->getConfig()['is_local'] ?? false) {
                return $storage->put($path, $this->downloadUrl($file));
            }

            //create temp file
            $tmpFile = tempnam(sys_get_temp_dir(), uniqid(strftime('%G-%m-%d')));

            //download file to temp file
            $http = $this->getContainer()->get(ClientInterface::class);
            $http->get($this->downloadUrl($file), array_merge(['sink' => $tmpFile], $clientOpt));

            //save temp file to disk
            return $storage->putFileAs('/', new LaravelFile($tmpFile), $path);
        };
    }
}
