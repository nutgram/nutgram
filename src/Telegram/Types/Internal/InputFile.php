<?php

namespace SergiX44\Nutgram\Telegram\Types\Internal;

/**
 * This object represents the contents of a file to be uploaded. Must be posted using
 * multipart/form-data in the usual way that files are uploaded via the browser.
 */
class InputFile
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
     * @param  mixed  $resource
     * @param  string|null  $filename
     */
    public function __construct($resource, ?string $filename = null)
    {
        $this->filename = $filename;
        if (is_resource($resource)) {
            $this->resource = $resource;
        } elseif (is_string($resource) && file_exists($resource)) {
            $this->resource = fopen($resource, 'rb+');
        } else {
            throw new \InvalidArgumentException('Invalid resource specified.');
        }
    }

    /**
     * @param  resource  $resource
     * @param  string|null  $filename
     * @return InputFile
     */
    public static function make($resource, ?string $filename = null): InputFile
    {
        return new self($resource, $filename);
    }

    /**
     * @param  string|null  $filename
     * @return InputFile
     */
    public function filename(?string $filename): InputFile
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return false|resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        $metadata = stream_get_meta_data($this->resource);

        if ($this->filename === null && isset($metadata['uri'])) {
            return basename($metadata['uri']);
        }

        return basename($this->filename ?? uniqid(more_entropy: true));
    }
}
