<?php

namespace SergiX44\Nutgram\Telegram\Types\Internal;

use GuzzleHttp\Psr7\Utils;
use InvalidArgumentException;
use JsonSerializable;
use Psr\Http\Message\StreamInterface;

/**
 * This object represents the contents of a file to be uploaded. Must be posted using
 * multipart/form-data in the usual way that files are uploaded via the browser.
 */
class InputFile implements JsonSerializable
{
    /**
     * @var StreamInterface
     */
    protected $resource;

    /**
     * @var string|null
     */
    protected ?string $filename;

    /**
     * @param resource|string $resource Resource or path to file
     * @param string|null $filename Filename
     */
    public function __construct(mixed $resource, ?string $filename = null)
    {
        $this->filename = $filename;
        if (is_resource($resource)) {
            $this->resource = Utils::streamFor($resource);
        } elseif (is_string($resource) && file_exists($resource)) {
            $res = fopen($resource, 'rb+');
            if ($res === false) {
                throw new InvalidArgumentException('Cannot open the specified resource.');
            }

            $this->resource = Utils::streamFor($res);
        } else {
            throw new InvalidArgumentException('Invalid resource specified.');
        }
    }

    /**
     * @param resource|string $resource Resource or path to file
     * @param string|null $filename Filename
     * @return InputFile
     */
    public static function make(mixed $resource, ?string $filename = null): InputFile
    {
        return new self($resource, $filename);
    }

    /**
     * @param string|null $filename
     * @return InputFile
     */
    public function filename(?string $filename): InputFile
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return StreamInterface
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        $uri = $this->resource->getMetadata('uri');

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
