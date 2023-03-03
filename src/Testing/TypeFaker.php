<?php

namespace SergiX44\Nutgram\Testing;

use BackedEnum;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
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
     * @param  class-string  $type
     * @param  array  $partial
     * @param  bool  $fillNullable
     * @return T|string|int|bool|array|null|float
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \ReflectionException
     */
    public function fakeInstanceOf(string $type, array $partial = [], bool $fillNullable = true): mixed
    {
        if (class_exists($type)) {
            $data = $this->fakeDataFor($type, $partial, $fillNullable);
            return $this->hydrator->hydrate($data, $type);
        }

        return self::randomScalarOf($type);
    }

    /**
     *
     * @param  class-string  $class
     * @param  array  $additional
     * @param  bool  $fillNullable
     * @param  array  $resolveStack
     *
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \ReflectionException
     */
    private function fakeDataFor(
        string $class,
        array $additional = [],
        bool $fillNullable = true,
        array $resolveStack = []
    ): array {
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

            // if specified by the user
            if (isset($additional[$property->name]) && !is_array($additional[$property->name])) {
                $data[$property->name] = $additional[$property->name];
                continue;
            }

            $isNullable = $property->getType()?->allowsNull();

            // if is not nullable, but the property is already initialized, take the value
            if (!$isNullable && $property->isInitialized($dummyInstance)) {
                $value = $property->getValue($dummyInstance);
                $data[$property->name] = $value instanceof BackedEnum ? $value->value : $value;
                continue;
            }

            if ($isNullable && !$fillNullable && !isset($additional[$property->name])) {
                $data[$property->name] = null;
                continue;
            }

            $typeName = $property->getType()?->getName();

            // if is a class, try to resolve it
            if ($this->shouldInstantiate($typeName, $resolveStack, $isNullable ?? false)) {
                $resolveStack[] = $typeName;
                $data[$property->name] = $this->fakeDataFor(
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
                    $arrayData = $this->fakeDataFor(
                        $typeArray,
                        $additional[$property->name] ?? [],
                        $fillNullable,
                        $resolveStack
                    );
                    $data[$property->name] = $this->wrap($arrayData, $nesting ?? 0);
                    continue;
                }
            }

            $data[$property->name] = self::randomScalarOf($typeName);
        }

        return $data;
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
        static $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat(
            $x,
            (int)ceil($length / strlen($x))
        )), 1, $length);
    }

    /**
     * @param  int  $min
     * @param  int|null  $max
     * @return int
     */
    public static function randomInt(int $min = 0, ?int $max = null): int
    {
        return mt_rand($min, $max ?? getrandmax());
    }

    /**
     * @return float
     */
    public static function randomFloat(): float
    {
        return abs(1 - self::randomInt() / self::randomInt());
    }
}
