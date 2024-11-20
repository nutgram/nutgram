<?php

namespace SergiX44\Nutgram\Support;

use RuntimeException;
use SergiX44\Hydrator\Hydrator;
use SergiX44\Nutgram\Exception\InvalidDataException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Web\LoginData;
use SergiX44\Nutgram\Telegram\Web\WebAppData;

/**
 * @mixin Nutgram
 */
trait ValidatesWebData
{
    public const PUBLICKEY_PROD = 'e7bf03a2fa4602af4580703d88dda5bb59f32ed8b02a56c187fe7d34caed242d';
    public const PUBLICKEY_TEST = '40055058a4ee38156a06562e52eece92a771bcd8346a8c4615cb7376eddf72ec';

    /**
     * Validates webapp data.
     * @param string $queryString The query string to validate.
     * @return WebAppData The validated web application data.
     * @throws InvalidDataException If the webapp data is invalid.
     * @see https://core.telegram.org/bots/webapps#validating-data-received-via-the-mini-app
     */
    public function validateWebAppData(string $queryString): WebAppData
    {
        [$sortedData, $remoteHash] = self::parseQueryString($queryString, ['hash']);
        $secretKey = $this->createHashHmac($this->token, 'WebAppData');
        $localHash = bin2hex($this->createHashHmac($sortedData, $secretKey));

        if (strcmp($localHash, $remoteHash) !== 0) {
            throw new InvalidDataException('Invalid webapp data');
        }

        return $this->hydrator->hydrate(self::queryStringToArray($queryString), WebAppData::class);
    }

    /**
     * Validate webapp data without knowing the App's bot token.
     * @param int $botId The bot ID.
     * @param string $queryString The query string to validate.
     * @param string $publicKey The public key to use for validation. You can use the constants `Nutgram::PUBLICKEY_PROD` and `Nutgram::PUBLICKEY_TEST`.
     * @return WebAppData The validated web application data.
     * @throws InvalidDataException If the webapp data is invalid.
     * @see https://core.telegram.org/bots/webapps#validating-data-for-third-party-use
     */
    public static function validateWebAppDataForThirdParty(
        int $botId,
        string $queryString,
        string $publicKey = self::PUBLICKEY_PROD
    ): WebAppData {
        if (!extension_loaded('sodium')) {
            throw new RuntimeException('Sodium extension is required for this method');
        }

        [$sortedData, , $signature] = self::parseQueryString($queryString, ['hash', 'signature']);
        $dataCheckString = sprintf("%s:WebAppData\n%s", $botId, $sortedData);

        if (!self::ed25519Verify($publicKey, $dataCheckString, $signature)) {
            throw new InvalidDataException('Invalid webapp data');
        }

        return (new Hydrator())->hydrate(WebAppData::class, self::queryStringToArray($queryString));
    }

    /**
     * Validate login data.
     * @param string $queryString The query string containing login data.
     * @return LoginData The validated login data.
     * @throws InvalidDataException If the login data is invalid.
     */
    public function validateLoginData(string $queryString): LoginData
    {
        [$sortedData, $remoteHash] = self::parseQueryString($queryString, ['hash']);
        $secretKey = $this->createHash($this->token);
        $localHash = bin2hex($this->createHashHmac($sortedData, $secretKey));

        if (!hash_equals($remoteHash, $localHash)) {
            throw new InvalidDataException('Invalid login data');
        }

        return $this->hydrator->hydrate(self::queryStringToArray($queryString), LoginData::class);
    }

    protected function createHashHmac(string $data, string $secretKey): string
    {
        return hash_hmac('sha256', $data, $secretKey, true);
    }

    protected function createHash(string $data): string
    {
        return hash('sha256', $data, true);
    }

    protected static function queryStringToArray(string $queryString): array
    {
        $data = [];
        parse_str($queryString, $data);
        return $data;
    }

    protected static function parseQueryString(string $queryString, array $pull = []): array
    {
        // convert url encoded string to array
        $data = self::queryStringToArray($queryString);

        // pull out data
        $pullData = [];
        foreach ($pull as $key) {
            $pullData[$key] = $data[$key] ?? null;
            unset($data[$key]);
        }

        // sort and stringify the remaining data
        ksort($data);
        $data = array_filter($data);
        $data = array_map(
            fn ($key, $value) => sprintf('%s=%s', $key, $value),
            array_keys($data),
            $data,
        );
        $stringData = implode("\n", $data);

        // return the sorted data and the pulled data
        return [$stringData, ...array_values($pullData)];
    }

    protected static function ed25519Verify(string $publicKey, string $dataCheckString, string $signature): bool
    {
        return sodium_crypto_sign_verify_detached(
            signature: sodium_base642bin($signature, SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING),
            message: $dataCheckString,
            public_key: sodium_hex2bin($publicKey),
        );
    }
}
