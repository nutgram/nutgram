<?php

namespace SergiX44\Nutgram\Telegram;

class Progress
{
    public function __construct(
        protected int $totalDownloadBytes,
        protected int $downloadedBytes,
        protected int $totalUploadBytes,
        protected int $uploadedBytes,
    ) {
    }

    public function totalDownloadBytes(): int
    {
        return $this->totalDownloadBytes;
    }

    public function downloadedBytes(): int
    {
        return $this->downloadedBytes;
    }

    public function totalUploadBytes(): int
    {
        return $this->totalUploadBytes;
    }

    public function uploadedBytes(): int
    {
        return $this->uploadedBytes;
    }

    public function getDownloadProgress(int $precision = 0): float
    {
        return $this->mapRange(
            current: $this->downloadedBytes,
            sourceStart: 1,
            sourceEnd: $this->totalDownloadBytes,
            precision: $precision
        );
    }

    public function getUploadProgress(int $precision = 0): float
    {
        return $this->mapRange(
            current: $this->uploadedBytes,
            sourceStart: 1,
            sourceEnd: $this->totalUploadBytes,
            precision: $precision
        );
    }

    /**
     * Map a source range to a target range
     * @param int $current
     * @param int $sourceStart
     * @param int $sourceEnd
     * @param int $targetStart
     * @param int $targetEnd
     * @param int $precision
     * @return float
     * @see https://math.stackexchange.com/a/914843
     */
    protected function mapRange(int $current, int $sourceStart, int $sourceEnd, int $targetStart = 1, int $targetEnd = 100, int $precision = 0): float
    {
        if ($sourceEnd <= 0) {
            return 0;
        }

        if ($sourceEnd === $sourceStart) {
            return $targetEnd;
        }

        $result = ($targetStart + (($targetEnd - $targetStart) / ($sourceEnd - $sourceStart)) * ($current - $sourceStart));

        return round($result, $precision);
    }
}
