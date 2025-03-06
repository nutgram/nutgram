<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Testing;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;
use Throwable;

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
        $this->method = $this->request->getMethod();
        $this->headers = $this->request->getHeaders();

        $contentType = $this->request->getHeaderLine('Content-Type');
        if (!preg_match('/boundary=(.*)$/is', $contentType, $matches)) {
            return $this;
        }

        $boundary = $matches[1];
        $body = (string)$this->request->getBody();
        $bodyParts = preg_split('/\\R?-+'.preg_quote($boundary, '/').'/s', $body);

        if ($bodyParts === false) {
            return $this;
        }

        array_pop($bodyParts);

        foreach ($bodyParts as $bodyPart) {
            if (empty($bodyPart)) {
                continue;
            }

            $splittedBody = preg_split('/\\R\\R/', $bodyPart, 2);
            if ($splittedBody === false) {
                [$headers, $value] = ['', ''];
            } else {
                [$headers, $value] = array_pad($splittedBody, 2, '');
            }

            $headers = $this->parseHeaders($headers);
            if (!isset($headers['content-disposition']['name'])) {
                continue;
            }
            if (isset($headers['content-disposition']['filename'])) {
                try {
                    $tmpResource = Utils::streamFor($value);
                    $error = UPLOAD_ERR_OK;
                } catch (Throwable) {
                    $error = UPLOAD_ERR_CANT_WRITE;
                    $tmpResource = null;
                }

                $this->files[$headers['content-disposition']['name']] = new OutgoingResource(
                    name: $headers['content-disposition']['filename'],
                    type: array_key_exists(
                        'content-type',
                        $headers
                    ) ? $headers['content-type'] : 'application/octet-stream',
                    size: mb_strlen($value, '8bit'),
                    error: $error,
                    stream: $tmpResource
                );
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

        if ($headerParts === false) {
            return $headers;
        }

        foreach ($headerParts as $headerPart) {
            if (!str_contains($headerPart, ':')) {
                continue;
            }

            [$headerName, $headerValue] = array_pad(explode(':', $headerPart, 2), 2, '');
            $headerName = strtolower(trim($headerName));
            $headerValue = trim($headerValue);

            if (!str_contains($headerValue, ';')) {
                $headers[$headerName] = $headerValue;
                continue;
            }

            $headers[$headerName] = [];
            foreach (explode(';', $headerValue) as $part) {
                $part = trim($part);
                if (!str_contains($part, '=')) {
                    $headers[$headerName][] = $part;
                } else {
                    [$name, $value] = array_pad(explode('=', $part, 2), 2, '');
                    $name = strtolower(trim($name));
                    $value = trim(trim($value), '"');
                    $headers[$headerName][$name] = $value;
                }
            }
        }

        return $headers;
    }
}
