<?php

namespace SergiX44\Nutgram\Web;

use SergiX44\Nutgram\Web\Entities\LoginData;
use SergiX44\Nutgram\Web\Entities\WebAppData;

trait ValidatesWebData
{
    /**
     * Validates webapp data.
     * @param string $queryString The query string to validate.
     * @return WebAppData The validated web application data.
     * @throws InvalidDataException If the webapp data is invalid.
     */
    public function validateWebAppData(string $queryString): WebAppData
    {
        [$remoteHash, $sortedData] = $this->parseQueryString($queryString);
        $secretKey = $this->createHashHmac($this->token, 'WebAppData');
        $localHash = bin2hex($this->createHashHmac($sortedData, $secretKey));

        if (strcmp($localHash, $remoteHash) !== 0) {
            throw new InvalidDataException('Invalid webapp data');
        }

        return WebAppData::fromArray($this->queryStringToArray($queryString));
    }

    /**
     * Validate login data.
     * @param string $queryString The query string containing login data.
     * @return LoginData The validated login data.
     * @throws InvalidDataException If the login data is invalid.
     */
    public function validateLoginData(string $queryString): LoginData
    {
        [$remoteHash, $sortedData] = $this->parseQueryString($queryString);
        $secretKey = $this->createHash($this->token);
        $localHash = bin2hex($this->createHashHmac($sortedData, $secretKey));

        if (!hash_equals($remoteHash, $localHash)) {
            throw new InvalidDataException('Invalid login data');
        }

        return LoginData::fromArray($this->queryStringToArray($queryString));
    }

    protected function createHashHmac(string $data, string $secretKey): string
    {
        return hash_hmac('sha256', $data, $secretKey, true);
    }

    protected function createHash(string $data): string
    {
        return hash('sha256', $data, true);
    }

    protected function queryStringToArray(string $queryString): array
    {
        $data = [];
        parse_str($queryString, $data);
        return $data;
    }

    protected function parseQueryString(string $queryString): array
    {
        // convert url encoded string to array
        $data = $this->queryStringToArray($queryString);

        // pull out the hash
        $hash = $data['hash'] ?? null;
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

    /**
     * Generates webapp data + hash.
     * @param array $data The data to generate webapp data from.
     * @return string The generated webapp data as query string.
     * @internal For testing purposes only.
     */
    public function generateWebAppData(array $data): string
    {
        $queryString = http_build_query(array_filter($data), encoding_type: PHP_QUERY_RFC3986);

        [, $sortedData] = $this->parseQueryString($queryString);
        $secretKey = $this->createHashHmac($this->token, 'WebAppData');
        $hash = bin2hex($this->createHashHmac($sortedData, $secretKey));

        return $queryString.'&hash='.$hash;
    }

    /**
     * Generates login data + hash.
     * @param array $data The data to generate login data from.
     * @return string The generated login data as query string.
     * @internal For testing purposes only.
     */
    public function generateLoginData(array $data): string
    {
        $queryString = http_build_query(array_filter($data));

        [, $sortedData] = $this->parseQueryString($queryString);
        $secretKey = $this->createHash($this->token);
        $hash = bin2hex($this->createHashHmac($sortedData, $secretKey));

        return $queryString.'&hash='.$hash;
    }
}
