<?php

namespace SergiX44\Nutgram\Telegram;

trait Responsible
{
    protected bool $enableAsResponse = false;
    protected bool $responseSent = false;

    public function asResponse(): self
    {
        $this->enableAsResponse = true;
        return $this;
    }

    protected function resetResponseSent(): void
    {
        $this->responseSent = false;
    }

    protected function canHandleAsResponse(): bool
    {
        return !$this->responseSent && $this->enableAsResponse && PHP_SAPI === 'fpm-fcgi' && function_exists('fastcgi_finish_request');
    }

    protected function sendResponse(string $methodName, array $payload): null
    {
        $out = ['method' => $methodName, ...$payload['json']];
        $response = json_encode($out, JSON_THROW_ON_ERROR);

        header('Connection: close');
        header('Content-Type: application/json');
        header(sprintf('HTTP/%s %s %s', '1.1', '200', 'OK'), true, 200);
        echo $response;
        fastcgi_finish_request();

        $this->responseSent = true;
        $this->enableAsResponse = false;

        return null;
    }
}
