<?php

namespace SergiX44\Nutgram\Telegram;

final readonly class Progress
{
    public function __construct(
        public int $totalDownloadBytes,
        public int $downloadedBytes,
        public int $totalUploadBytes,
        public int $uploadedBytes,
    ) {
    }

    public function downloadPercentage(int $precision = 0): float
    {
        return $this->mapRange(
            current: $this->downloadedBytes,
            sourceStart: 1,
            sourceEnd: $this->totalDownloadBytes,
            precision: $precision
        );
    }

    public function uploadPercentage(int $precision = 0): float
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
