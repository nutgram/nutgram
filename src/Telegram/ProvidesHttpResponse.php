<?php

namespace SergiX44\Nutgram\Telegram;

trait ProvidesHttpResponse
{
    protected bool $enableAsResponse = false;
    protected bool $responseSent = false;

    public function asResponse(): self
    {
        $this->enableAsResponse = true;
        return $this;
    }

    protected function canHandleAsResponse(): bool
    {
        return !$this->responseSent && $this->enableAsResponse && function_exists('fastcgi_finish_request');
    }

    protected function sendResponse(string $methodName, array $payload): null
    {
        header('Content-Type: application/json');
        echo json_encode(['method' => $methodName, ...$payload['json']], JSON_THROW_ON_ERROR);
        @ob_end_flush();
        fastcgi_finish_request();

        $this->responseSent = true;
        $this->enableAsResponse = false;

        return null;
    }
}
