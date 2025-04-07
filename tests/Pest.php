<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use SergiX44\Nutgram\Tests\TelegramTypeContext;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

pest()
    ->extend(TestCase::class)
    ->in('Feature', 'Unit', 'E2E');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function getUpdateType(string $type, bool $associative = false): array|stdClass
{
    return json_decode(
        file_get_contents(__DIR__."/Fixtures/Updates/$type.json"),
        $associative,
        flags: JSON_THROW_ON_ERROR
    );
}

/**
 * @param TelegramTypeContext $context
 * @return ReflectionClass[]
 * @throws ReflectionException
 */
function getTelegramTypes(TelegramTypeContext $context = TelegramTypeContext::All): array
{
    $classes = glob(__DIR__.'/../src/Telegram/Types/**/*.php');

    $types = array_map(function (string $classPath) {
        $classPath = realpath($classPath);
        $classPath = str_replace(
            search: ['/', realpath(__DIR__.'/../src/'), '.php'],
            replace: ['\\', 'SergiX44\Nutgram', ''],
            subject: $classPath,
        );

        return new ReflectionClass($classPath);
    }, $classes);

    return array_values(array_filter($types, function (ReflectionClass $class) use ($context) {
        if (str_contains($class->getName(), 'SergiX44\Nutgram\Telegram\Types\Internal')) {
            return false;
        }

        if ($context === TelegramTypeContext::All) {
            return true;
        }

        if ($context === TelegramTypeContext::NonAbstract) {
            return !$class->isAbstract();
        }

        if ($context === TelegramTypeContext::Abstract) {
            return $class->isAbstract();
        }

        if ($context === TelegramTypeContext::Buildable) {
            return $class->getMethod('__construct')?->getDeclaringClass()?->getName() === $class->getName();
        }

        return false;
    }));
}
