<?php

namespace SergiX44\Nutgram\Testing;

use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionProperty;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Hydrator\Hydrator;

class TypeFaker
{
    /**
     * @param  Hydrator  $hydrator
     */
    public function __construct(private Hydrator $hydrator)
    {
    }

    /**
     * @template T
     * @param  class-string<T>  $type
     * @param  array  $partial
     * @param  bool  $fillNullable
     * @return T|string|int|bool|array|null|float
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \ReflectionException
     */
    public function fakeInstanceOf(string $type, array $partial = [], bool $fillNullable = true): mixed
    {
        if (class_exists($type)) {
            return $this->fakeInstance($type, $partial, $fillNullable);
        }

        return $this->randomScalarOf($type);
    }

    /**
     * @template T
     *
     * @param class-string<T>  $class
     * @param array  $additional
     * @param array  $resolveStack
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \ReflectionException
     */
    private function fakeInstance(
        string $class,
        array $additional = [],
        bool $fillNullable = true,
        array $resolveStack = []
    ): object {
        $reflectionClass = new ReflectionClass($class);

        if ($reflectionClass->isAbstract()) {
            /** @var ConcreteResolver $concrete */
            $concretes = $this->hydrator->getConcreteFor($reflectionClass->getName())?->getConcretes();
            if ($concretes !== null) {
                $concreteClass = array_shift($concretes);
                $reflectionClass = new ReflectionClass($concreteClass);
            }
        }

        $data = [];
        $dummyInstance = $reflectionClass->newInstanceWithoutConstructor();
        foreach ($reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $typeName = $property->getType()?->getName();
            $isNullable = $property->getType()?->allowsNull();

            // if specified by the user
            if (isset($additional[$property->name]) && !is_array($additional[$property->name])) {
                $data[$property->name] = $additional[$property->name];
                continue;
            }

            // if is not nullable, but the property is already initialized, that's good
            if (!$isNullable && $property->isInitialized($dummyInstance)) {
                continue;
            }

            if ($isNullable && !$fillNullable && !isset($additional[$property->name])) {
                $data[$property->name] = null;
                continue;
            }

            // if is a class, try to resolve it
            if ($this->shouldInstantiate($typeName, $resolveStack, $isNullable ?? false)) {
                $resolveStack[] = $typeName;
                $data[$property->name] = $this->fakeInstance(
                    $typeName,
                    $additional[$property->name] ?? [],
                    $fillNullable,
                    $resolveStack
                );
                continue;
            }

            // try to resolve the array type
            if ($typeName === 'array' && preg_match('/@var\s+(\S+)/', $property->getDocComment(), $matches)) {
                $typeArray = str_ireplace('[]', '', $matches[1], $nesting);
                if ($this->shouldInstantiate($typeArray, $resolveStack, $isNullable)) {
                    $resolveStack[] = $typeArray;
                    $arrayInstance = $this->fakeInstance(
                        $typeArray,
                        $additional[$property->name] ?? [],
                        $fillNullable,
                        $resolveStack
                    );
                    $data[$property->name] = $this->wrap($arrayInstance, $nesting ?? 0);
                    continue;
                }
            }

            $data[$property->name] = self::randomScalarOf($typeName);
        }

        return $this->hydrator->hydrate($data, $reflectionClass->getName());
    }


    /**
     * @param  string  $class
     * @param  array  $stack
     * @param  bool  $isNullable
     * @return bool
     */
    protected function shouldInstantiate(string $class, array $stack, bool $isNullable): bool
    {
        return class_exists($class) && (!in_array($class, $stack, true) || !$isNullable);
    }


    /**
     * @param  mixed  $what
     * @param  int  $layer
     * @return array
     */
    protected function wrap(mixed $what, int $layer = 0): array
    {
        if ($layer > 1) {
            return [$this->wrap($what, --$layer)];
        }

        return [$what];
    }

    /**
     * @param  string  $type
     * @return string|int|bool|array|float|null
     * @throws \Exception
     */
    public static function randomScalarOf(string $type): string|int|bool|array|null|float
    {
        return match ($type) {
            'int' => self::randomInt(),
            'string' => self::randomString(),
            'bool' => self::randomInt(0, 1) === 1,
            'float' => self::randomFloat(),
            'array' => [], // fallback
            default => null
        };
    }

    /**
     * @param  int  $length
     * @return string
     */
    public static function randomString(int $length = 8): string
    {
        return substr(str_shuffle(str_repeat(
            $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            (int)ceil($length / strlen($x))
        )), 1, $length);
    }

    /**
     * @param  int  $min
     * @param  int  $max
     * @return int
     * @throws \Exception
     */
    public static function randomInt(int $min = 0, int $max = PHP_INT_MAX): int
    {
        return random_int($min, $max);
    }

    /**
     * @return float
     * @throws \Exception
     */
    public static function randomFloat(): float
    {
        return abs(1 - self::randomInt() / self::randomInt());
    }
}
