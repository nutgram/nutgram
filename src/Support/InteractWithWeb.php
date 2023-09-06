<?php

namespace SergiX44\Nutgram\Support;

trait InteractWithWeb
{
    public function isWebAppDataValid(string $initData): bool
    {
        [$remoteHash, $sortedInitData] = $this->parseInitData($initData);
        $secretKey = $this->createHashHmac($this->token, 'WebAppData');
        $localHash = bin2hex($this->createHashHmac($sortedInitData, $secretKey));

        return strcmp($localHash, $remoteHash) === 0;
    }

    public function isLoginDataValid(string $initData): bool
    {
        [$remoteHash, $sortedInitData] = $this->parseInitData($initData);
        $localHash = bin2hex($this->createHashHmac($sortedInitData, $this->createHash($this->token)));

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

    protected function parseInitData(string $initData): array
    {
        // convert url encoded string to array
        $initDataArray = [];
        parse_str($initData, $initDataArray);

        // pull out the hash
        $hash = $initDataArray['hash'];
        unset($initDataArray['hash']);

        // sort and stringify the remaining data
        ksort($initDataArray);
        $initDataArray = array_filter($initDataArray);
        $initDataArray = array_map(
            fn ($key, $value) => sprintf('%s=%s', $key, $value),
            array_keys($initDataArray),
            $initDataArray,
        );
        $initDataString = implode("\n", $initDataArray);

        // return the hash and the sorted data
        return [$hash, $initDataString];
    }
}
