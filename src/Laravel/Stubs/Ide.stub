<?php

namespace SergiX44\Nutgram\Telegram\Types\Media {

    class File
    {

        /**
         * @param string $path
         * @param string|null $disk
         * @param array $clientOpt
         * @return bool
         */
        public function saveToDisk(string $path, string $disk = null, array $clientOpt = []): bool
        {
            /** @var File $instance */
            return $instance->saveToDisk($path, $disk, $clientOpt);
        }

    }

}

namespace SergiX44\Nutgram {

    use SergiX44\Nutgram\Telegram\Types\Media\File;

    class Nutgram
    {
        /**
         * @param File $file
         * @param string $path
         * @param string|null $disk
         * @param array $clientOpt
         * @return bool
         */
        public function downloadFileToDisk(File $file, string $path, string $disk = null, array $clientOpt = []): bool
        {
            /** @var Nutgram $instance */
            return $instance->downloadFileToDisk($file, $path, $disk, $clientOpt);
        }
    }
}
