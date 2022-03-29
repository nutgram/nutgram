<?php

namespace SergiX44\Nutgram\Testing;

use GuzzleHttp\Psr7\Request;

class FormDataParser
{
    protected Request $request;

    public string $method;
    public array $headers = [];
    public array $params = [];
    public array $files = [];

    protected function __construct(Request $request)
    {
        $this->request = $request;
    }

    public static function parse(Request $request): self
    {
        return (new static($request))->parseRequest();
    }

    protected function parseRequest(): self
    {
        //get method type
        $this->method = $this->request->getMethod();

        //get headers
        $this->headers = $this->request->getHeaders();

        //get content-type
        $contentType = $this->request->getHeaderLine('Content-Type');

        //get body
        $body = (string)$this->request->getBody();

        if (!preg_match('/boundary=(.*)$/is', $contentType, $matches)) {
            return $this;
        }

        $boundary = $matches[1];
        $bodyParts = preg_split('/\\R?-+'.preg_quote($boundary, '/').'/s', $body);
        array_pop($bodyParts);

        foreach ($bodyParts as $bodyPart) {
            if (empty($bodyPart)) {
                continue;
            }
            [$headers, $value] = preg_split('/\\R\\R/', $bodyPart, 2);
            $headers = $this->parseHeaders($headers);
            if (!isset($headers['content-disposition']['name'])) {
                continue;
            }
            if (isset($headers['content-disposition']['filename'])) {
                $formDataFile = new OutgoingResource();
                $formDataFile->name = $headers['content-disposition']['filename'];
                $formDataFile->type = array_key_exists('content-type',
                    $headers) ? $headers['content-type'] : 'application/octet-stream';
                $formDataFile->size = mb_strlen($value, '8bit');
                $formDataFile->error = UPLOAD_ERR_OK;
                $formDataFile->tmp_name = null;

                if ($formDataFile->size > $this->toBytes(ini_get('upload_max_filesize'))) {
                    $formDataFile->error = UPLOAD_ERR_INI_SIZE;
                } else {
                    $tmpResource = tmpfile();
                    if ($tmpResource === false) {
                        $formDataFile->error = UPLOAD_ERR_CANT_WRITE;
                    } else {
                        $tmpResourceMetaData = stream_get_meta_data($tmpResource);
                        $tmpFileName = $tmpResourceMetaData['uri'];
                        if (empty($tmpFileName)) {
                            $formDataFile->error = UPLOAD_ERR_CANT_WRITE;
                            @fclose($tmpResource);
                        } else {
                            fwrite($tmpResource, $value);
                            $formDataFile->tmp_name = $tmpFileName;
                            $formDataFile->tmp_resource = $tmpResource;
                        }
                    }
                }
                $this->files[$headers['content-disposition']['name']] = $formDataFile;
            } else {
                $this->params[$headers['content-disposition']['name']] = $value;
            }
        }

        return $this;
    }

    /**
     * Parses body param headers
     * @param  string  $headerContent
     * @return array
     */
    protected function parseHeaders(string $headerContent): array
    {
        $headers = [];
        $headerParts = preg_split('/\\R/s', $headerContent, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($headerParts as $headerPart) {
            if (!str_contains($headerPart, ':')) {
                continue;
            }
            [$headerName, $headerValue] = explode(':', $headerPart, 2);
            $headerName = strtolower(trim($headerName));
            $headerValue = trim($headerValue);
            if (!str_contains($headerValue, ';')) {
                $headers[$headerName] = $headerValue;
            } else {
                $headers[$headerName] = [];
                foreach (explode(';', $headerValue) as $part) {
                    $part = trim($part);
                    if (!str_contains($part, '=')) {
                        $headers[$headerName][] = $part;
                    } else {
                        [$name, $value] = explode('=', $part, 2);
                        $name = strtolower(trim($name));
                        $value = trim(trim($value), '"');
                        $headers[$headerName][$name] = $value;
                    }
                }
            }
        }

        return $headers;
    }

    /**
     * Formatted bytes to bytes
     * @param  string  $formattedBytes
     * @return int|null
     */
    protected function toBytes(string $formattedBytes): ?int
    {
        $units = ['B', 'K', 'M', 'G', 'T', 'P'];
        $unitsExtended = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        $number = (int)preg_replace("/[^0-9]+/", "", $formattedBytes);
        $suffix = preg_replace("/[^a-zA-Z]+/", "", $formattedBytes);

        //B or no suffix
        if (is_numeric($suffix[0])) {
            return preg_replace('/[^\d]/', '', $formattedBytes);
        }

        $exponent = array_flip($units)[$suffix] ?? null;
        if ($exponent === null) {
            $exponent = array_flip($unitsExtended)[$suffix] ?? null;
        }

        if ($exponent === null) {
            return null;
        }

        return $number * (1024 ** $exponent);
    }
}
