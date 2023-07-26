<?php

namespace SergiX44\Nutgram\Telegram\Types\Internal;

use InvalidArgumentException;
use JsonSerializable;

/**
 * This object represents the contents of a file to be uploaded. Must be posted using
 * multipart/form-data in the usual way that files are uploaded via the browser.
 */
class InputFile implements JsonSerializable
{
    /**
     * @var resource
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
            $this->resource = $resource;
        } elseif (is_string($resource) && file_exists($resource)) {
            $res = fopen($resource, 'rb+');
            if ($res === false) {
                throw new InvalidArgumentException('Cannot open the specified resource.');
            }

            $this->resource = $res;
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
     * @return resource
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
        $metadata = stream_get_meta_data($this->resource);

        if ($this->filename === null && isset($metadata['uri'])) {
            return basename($metadata['uri']);
        }

        return basename($this->filename ?? uniqid(more_entropy: true));
    }

    public function jsonSerialize(): string
    {
        return "attach://{$this->getFilename()}";
    }
}
