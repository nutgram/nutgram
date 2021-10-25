<?php

namespace SergiX44\Nutgram\Telegram\Internal;

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
     * @param $resource
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
     * @param $resource
     * @param  string|null  $filename
     * @return InputFile
     */
    public static function make($resource, ?string $filename = null): InputFile
    {
        return new self($resource, $filename);
    }

    public function __destruct()
    {
        if (is_resource($this->resource)) {
            fclose($this->resource);
        }
    }

    /**
     * @param  string|null  $filename
     * @return InputFile
     */
    public function setFilename(?string $filename): InputFile
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

        if ($this->filename === null && !isset($metadata['uri'])) {
            return uniqid(more_entropy: true);
        }

        if ($this->filename === null && isset($metadata['uri'])) {
            return $metadata['uri'];
        }

        return $this->filename;
    }
}
