<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Testing;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;
use Riverline\MultiPartParser\StreamedPart;
use Throwable;
use function SergiX44\Nutgram\Support\dot_get;
use function SergiX44\Nutgram\Support\dot_has;
use function SergiX44\Nutgram\Support\is_nonscalar_json;

class RequestData
{
    protected string $endpoint;
    protected string $method;
    protected array $headers = [];
    protected array $rawData = [];
    protected array $data = [];
    protected array $files = [];
    protected bool $multipart = false;


    public function __construct(Request $request)
    {
        $this->parse($request);
    }

    protected function parse(Request $request): void
    {
        $this->endpoint = $request->getUri()->getPath();
        $this->method = $request->getMethod();
        $this->headers = array_map(fn (array $value) => $value[0], $request->getHeaders());

        try {
            $body = (string)$request->getBody();

            if (json_validate($body)) {
                $data = json_decode($body, true, flags: JSON_THROW_ON_ERROR);
                $this->data = $data;
                $this->rawData = $data;
                return;
            }

            $this->parseMultipart($body);
        } catch (Throwable) {
            // :/
        }
    }

    protected function parseMultipart(string $body): void
    {
        $body = 'Content-Type: '.$this->header('Content-Type')."\n\n".$body;
        $content = new StreamedPart(Utils::streamFor($body)->detach());

        if (!$content->isMultipart()) {
            return;
        }

        $this->multipart = true;
        $parts = $content->getParts();
        foreach ($parts as $part) {
            if (!$part->isFile()) {
                $this->rawData[$part->getName()] = $part->getBody();
                $this->data[$part->getName()] = $this->remapBodyPart($part->getBody());
                continue;
            }

            $stream = Utils::streamFor($part->getBody());
            $this->files[$part->getName()] = new OutgoingResource(
                name: $part->getFileName(),
                mime: $part->getMimeType(),
                size: $stream->getSize(),
                stream: $stream,
            );
        }
    }

    protected function remapBodyPart(mixed $value): mixed
    {
        if (is_string($value) && json_validate($value) && is_nonscalar_json($value)) {
            return json_decode($value, true, flags: JSON_THROW_ON_ERROR);
        }

        return $value;
    }

    /**
     * @param (callable(static): bool)|bool $condition
     * @param callable(static): (static|null) $onSuccess
     * @param ?callable(static): (static|null) $onFail
     * @return static
     */
    public function when(callable|bool $condition, callable $onSuccess, ?callable $onFail = null): static
    {
        if (!is_bool($condition)) {
            $condition = $condition($this);
        }

        return match (true) {
            $condition => $onSuccess($this),
            null !== $onFail => $onFail($this),
            default => $this,
        } ?? $this;
    }

    public function isMultipart(): bool
    {
        return $this->multipart;
    }

    public function withMapping(array $mapping): static
    {
        $caster = fn (string $cast, mixed $value) => match ($cast) {
            'integer', 'int' => filter_var($value, FILTER_VALIDATE_INT),
            'double', 'float' => filter_var($value, FILTER_VALIDATE_FLOAT),
            'boolean', 'bool' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            default => $value,
        };

        foreach ($mapping as $key => $cast) {
            if (array_key_exists($key, $this->data)) {
                $this->data[$key] = $caster($cast, $this->data[$key]);
            }

            if (array_key_exists($key, $this->rawData)) {
                $this->rawData[$key] = $caster($cast, $this->rawData[$key]);
            }
        }

        return $this;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function header(string $key, mixed $default = null): mixed
    {
        return $this->headers[$key] ?? $default;
    }

    public function hasHeader(string $key): bool
    {
        return array_key_exists($key, $this->headers);
    }

    public function missingHeader(string $key): bool
    {
        return !$this->hasHeader($key);
    }

    public function all(): array
    {
        return $this->data;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return dot_get($this->data, $key, $default);
    }

    public function has(string $key): bool
    {
        return dot_has($this->data, $key);
    }

    public function missing(string $key): bool
    {
        return !$this->has($key);
    }

    public function allRaw(): array
    {
        return $this->rawData;
    }

    public function getRaw(string $key, mixed $default = null): mixed
    {
        return dot_get($this->rawData, $key, $default);
    }

    public function hasRaw(string $key): bool
    {
        return dot_has($this->rawData, $key);
    }

    public function missingRaw(string $key): bool
    {
        return !$this->has($key);
    }

    public function files(): array
    {
        return $this->files;
    }

    public function file(string $key): ?OutgoingResource
    {
        $key = str_replace('attach://', '', $key);
        return $this->files[$key] ?? null;
    }

    public function hasFile(string $key): bool
    {
        return array_key_exists($key, $this->files);
    }

    public function missingFile(string $key): bool
    {
        return !$this->hasFile($key);
    }
}
