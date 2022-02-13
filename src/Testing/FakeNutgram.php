<?php

namespace SergiX44\Nutgram\Testing;

use Exception;
use SergiX44\Nutgram\Nutgram;

class FakeNutgram extends Nutgram
{
    use Testable;

    /**
     * @param  string  $name
     * @param  array  $arguments
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return self::$bot->$name(...$arguments);
    }

    /**
     * @param  string  $name
     * @param  array  $arguments
     * @return void
     * @throws Exception
     */
    public function __call(string $name, array $arguments)
    {
        $lowerName = strtolower($name);

        // begin assertion
        match (str_starts_with($lowerName, 'assert')) {
            str_ends_with($lowerName, 'called') => $this->assertApiMethodCalled($this->extractName($name, 'called'), $arguments),
            default => throw new Exception('Invalid assertion')
        };
    }

    /**
     * @param  string  $name
     * @param  string  $string
     * @return string
     */
    private function extractName(string $name, string $string): string
    {
        return lcfirst(str_ireplace(['assert', $string], '', $name));
    }

    /**
     * @param $method
     * @param $arguments
     * @return void
     */
    private function assertApiMethodCalled($method, $arguments)
    {
        dd($method);
    }


}