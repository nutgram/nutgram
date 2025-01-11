<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal;

use GuzzleHttp\Psr7\Utils;
use InvalidArgumentException;
use JsonSerializable;
use Psr\Http\Message\StreamInterface;
use Throwable;

/**
 * This object represents the contents of a file to be uploaded. Must be posted using
 * multipart/form-data in the usual way that files are uploaded via the browser.
 */
class InputFile implements JsonSerializable
{
    protected StreamInterface $stream;
    protected ?string $filename;

    /**
     * @param StreamInterface|resource|string $stream StreamInterface, resource, filepath or URI
     * @param string|null $filename Custom filename
     */
    public function __construct(mixed $stream, ?string $filename = null)
    {
        $this->stream = $this->buildStream($stream);
        $this->filename = $filename;
    }

    /**
     * @param StreamInterface|resource|string $stream StreamInterface, resource, filepath or URI
     * @param string|null $filename Custom filename
     * @return InputFile
     */
    public static function make(mixed $stream, ?string $filename = null): InputFile
    {
        return new self($stream, $filename);
    }

    public static function makeFromString(string $content, ?string $filename = null): InputFile
    {
        return new self(Utils::streamFor($content), $filename);
    }

    protected function buildStream(mixed $value): StreamInterface
    {
        if ($value instanceof StreamInterface) {
            return $value;
        }

        if (is_resource($value)) {
            return Utils::streamFor($value);
        }

        if (is_string($value)) {
            $resource = Utils::tryFopen($value, 'rb');
            return Utils::streamFor($resource);
        }

        throw new InvalidArgumentException('Invalid stream specified.');
    }

    public function filename(?string $filename): InputFile
    {
        $this->filename = $filename;
        return $this;
    }

    public function getStream(): StreamInterface
    {
        return $this->stream;
    }

    public function getFilename(): string
    {
        $uri = $this->stream->getMetadata('uri');

        if ($this->filename === null && !empty($uri)) {
            return basename($uri);
        }

        return basename($this->filename ?? uniqid(more_entropy: true));
    }

    public function jsonSerialize(): string
    {
        return "attach://{$this->getFilename()}";
    }
}
