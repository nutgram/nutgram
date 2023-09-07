<?php

namespace SergiX44\Nutgram\Web;

trait ValidatesWebData
{
    public function validateWebAppData(string $queryString): bool
    {
        [$remoteHash, $sortedData] = $this->parseQueryString($queryString);
        $secretKey = $this->createHashHmac($this->token, 'WebAppData');
        $localHash = bin2hex($this->createHashHmac($sortedData, $secretKey));

        return strcmp($localHash, $remoteHash) === 0;
    }

    public function validateLoginData(string $queryString): bool
    {
        [$remoteHash, $sortedData] = $this->parseQueryString($queryString);
        $secretKey = $this->createHash($this->token);
        $localHash = bin2hex($this->createHashHmac($sortedData, $secretKey));

        return hash_equals($remoteHash, $localHash);
    }

    protected function createHashHmac(string $data, string $secretKey): string
    {
        return hash_hmac('sha256', $data, $secretKey, true);
    }

    protected function createHash(string $data): string
    {
        return hash('sha256', $data, true);
    }

    protected function parseQueryString(string $queryString): array
    {
        // convert url encoded string to array
        $data = [];
        parse_str($queryString, $data);

        // pull out the hash
        $hash = $data['hash'];
        unset($data['hash']);

        // sort and stringify the remaining data
        ksort($data);
        $data = array_filter($data);
        $data = array_map(
            fn ($key, $value) => sprintf('%s=%s', $key, $value),
            array_keys($data),
            $data,
        );
        $stringData = implode("\n", $data);

        // return the hash and the sorted data
        return [$hash, $stringData];
    }
}
