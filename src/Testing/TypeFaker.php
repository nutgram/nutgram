<?php

namespace SergiX44\Nutgram\Testing;

use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionProperty;

class TypeFaker
{

    /**
     * @param  ContainerInterface  $container
     */
    public function __construct(private ContainerInterface $container)
    {
    }

    /**
     * @template T
     * @param  class-string<T>  $class
     * @param  array  $partial
     * @return T
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \ReflectionException
     */
    public function fakeInstanceOf(string $class, array $partial = []): mixed
    {
        if (class_exists($class)) {
            return $this->fakeInstance($class, $partial);
        }

        return $this->randomScalarOf($class);
    }

    /**
     * @template T
     * @param  class-string<T>  $class
     * @param  array  $partial
     * @param  array  $resolveStack
     * @return T
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \ReflectionException
     */
    private function fakeInstance(string $class, array $partial = [], array $resolveStack = [])
    {
        $reflectionClass = new ReflectionClass($class);

        $instance = $this->container->get($class);
        $properties = $reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $property) {
            $typeName = $property->getType()?->getName();
            $isNullable = $property->getType()?->allowsNull();

            // if specified by the user
            if (array_key_exists($property->name, $partial) && !is_array($partial[$property->name])) {
                $instance->{$property->name} = $partial[$property->name];
                continue;
            }

            // if is a class, try to resolve it
            if ($this->shouldInstantiate($typeName, $resolveStack, $isNullable)) {
                $resolveStack[] = $typeName;
                $instance->{$property->name} = $this->fakeInstance(
                    $typeName,
                    $partial[$property->name] ?? [],
                    $resolveStack
                );
                continue;
            }

            // try to resolve the array type
            if ($typeName === 'array' && preg_match('/@var\s+(\S+)/', $property->getDocComment(), $matches)) {
                $typeArray = str_ireplace('[]', '', $matches[1], $nesting);
                if ($this->shouldInstantiate($typeArray, $resolveStack, $isNullable)) {
                    $resolveStack[] = $typeArray;
                    $arrayInstance = $this->fakeInstance($typeArray, $partial[$property->name] ?? [], $resolveStack);
                    $instance->{$property->name} = $this->wrap($arrayInstance, $nesting);
                    continue;
                }
            }

            $instance->{$property->name} = $this->randomScalarOf($typeName);
        }

        return $instance;
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
    public function randomScalarOf(string $type): string|int|bool|array|null|float
    {
        return match ($type) {
            'int' => $this->randomInt(),
            'string' => $this->randomString(),
            'bool' => (bool) $this->randomInt(0, 1),
            'float' => $this->randomFloat(),
            'array' => [], // fallback
            default => null
        };
    }

    /**
     * @param  int  $length
     * @return string
     */
    public function randomString(int $length = 8): string
    {
        return substr(str_shuffle(str_repeat(
            $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            ceil($length / strlen($x))
        )), 1, $length);
    }

    /**
     * @param  int  $min
     * @param  int  $max
     * @return int
     * @throws \Exception
     */
    public function randomInt(int $min = 0, int $max = PHP_INT_MAX): int
    {
        return random_int($min, $max);
    }

    /**
     * @return float
     * @throws \Exception
     */
    public function randomFloat(): float
    {
        return abs(1 - $this->randomInt() / $this->randomInt());
    }
}
