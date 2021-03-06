<?php


namespace SergiX44\Nutgram\Proxies;

/**
 * Trait UpdateDataProxy
 * @package SergiX44\Nutgram\Proxies
 */
trait UpdateDataProxy
{
    private array $store = [];

    /**
     * @param $key
     * @param  null  $default
     * @return mixed|null
     */
    public function getData($key, $default = null)
    {
        return $this->store[$key] ?? $default;
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function setData($key, $value)
    {
        return $this->store[$key] = $value;
    }

    /**
     * @param $key
     */
    public function deleteData($key)
    {
        unset($this->store[$key]);
    }

    /**
     *
     */
    public function clearData(): void
    {
        $this->store = [];
    }
}
