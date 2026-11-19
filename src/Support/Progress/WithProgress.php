<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Support\Progress;

use SergiX44\Container\Container;
use SergiX44\Nutgram\Support\Progress\Triggers\EveryByte;

trait WithProgress
{
    abstract public function getContainer(): Container;

    protected ?array $progressHandler = null;

    /**
     * @param callable|class-string|array $callable
     * @param Trigger|null $trigger
     * @return $this
     */
    public function withProgress(callable|string|array $callable, ?Trigger $trigger = null): static
    {
        $trigger ??= new EveryByte();
        $this->progressHandler = [$callable, $trigger];
        return $this;
    }

    protected function setGuzzleHandler(array &$clientOpt, ProgressType $type): void
    {
        if ($this->progressHandler === null) {
            return;
        }

        /** @var callable $callable */
        /** @var Trigger $trigger */
        [$callable, $trigger] = $this->progressHandler;
        $this->progressHandler = null;

        $clientOpt = [
            'progress' => function (
                int $totalDownloadBytes,
                int $downloadedBytes,
                int $totalUploadBytes,
                int $uploadedBytes,
            ) use ($type, $callable, $trigger) {
                $progress = new Progress(
                    totalBytes: $type === ProgressType::Download ? $totalDownloadBytes : $totalUploadBytes,
                    currentBytes: $type === ProgressType::Download ? $downloadedBytes : $uploadedBytes,
                    type: $type,
                );

                $canInvokeProgress = $this->getContainer()->call(
                    callable: [$trigger, 'handle'],
                    arguments: [$progress, $this->getContainer()],
                );

                if (!$canInvokeProgress) {
                    return;
                }

                $this->getContainer()->call($callable, [$progress, $this]);
            },
            ...$clientOpt,
        ];
    }
}
