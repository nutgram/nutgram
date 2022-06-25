<?php

namespace SergiX44\Nutgram\Laravel\Mixins;

use Illuminate\Support\Facades\Storage;
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

            if (is_dir($path)) {
                $path = rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
                $path .= basename($file->file_path);
            }

            $savedPath = Storage::disk($disk)->path($path);

            $url = $this->downloadUrl($file);
            if ($this->getConfig()['is_local'] ?? false) {
                return copy($url, $savedPath);
            }

            $http = $this->getContainer()->get(ClientInterface::class);
            $http->get($url, array_merge(['sink' => $savedPath, $clientOpt]));

            return true;
        };
    }
}
