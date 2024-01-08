<?php

namespace SergiX44\Nutgram\Testing;

use BackedEnum;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Hydrator\Hydrator;
use Throwable;

class TypeFaker
{
    private array $resolveStack = [];

    /**
     * @param Hydrator $hydrator
     */
    public function __construct(private Hydrator $hydrator)
    {
    }

    /**
     * @template T
     * @param class-string $type
     * @param array $partial
     * @return T|string|int|bool|array|null|float
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function fakeInstanceOf(string $type, array $partial = []): mixed
    {
        try {
            if (class_exists($type)) {
                $data = $this->fakeDataFor($type, $partial);
                return $this->hydrator->hydrate($data, $type);
            }

            return self::randomScalarOf($type);
        } finally {
            $this->resolveStack = [];
        }
    }

    /**
     *
     * @param class-string $class
     * @param array $additional
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    private function fakeDataFor(
        string $class,
        array $additional = [],
    ): array {
        $this->resolveStack[] = $class;
        $reflectionClass = $this->getReflectionClass($class, $additional);

        $data = [];
        $dummyInstance = $reflectionClass->newInstanceWithoutConstructor();
        foreach ($reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $userDefined = $additional[$property->name] ?? [];

            // if specified by the user
            if (!is_array($userDefined)) {
                $data[$property->name] = $additional[$property->name];
                continue;
            }

            $isNullable = $property->getType()?->allowsNull() ?? false;

            if ($isNullable && !isset($additional[$property->name])) {
                $data[$property->name] = null;
                continue;
            }

            // if is not nullable, but the property is already initialized, take the value
            if (!$isNullable && $property->isInitialized($dummyInstance)) {
                $value = $property->getValue($dummyInstance);
                $data[$property->name] = $value instanceof BackedEnum ? $value->value : $value;
                continue;
            }

            $typeName = $property->getType() instanceof \ReflectionUnionType
                ? $property->getType()->getTypes()[0]->getName()
                : $property->getType()?->getName();

            // if is a class, try to resolve it
            if ($this->shouldInstantiate($typeName, $isNullable)) {
                $data[$property->name] = $this->fakeDataFor($typeName, $userDefined);
                continue;
            }

            $attributes = $property->getAttributes(ArrayType::class);
            /** @var ArrayType|null $arrayType */
            $arrayType = array_shift($attributes)?->newInstance();
            if ($arrayType !== null && $this->shouldInstantiate($arrayType->class, $isNullable)) {
                $data[$property->name] = $this->fakeArray($arrayType, $userDefined);
                continue;
            }

            // if is an enum, set the first case
            if (is_subclass_of($typeName, BackedEnum::class)) {
                $cases = $typeName::cases();
                $data[$property->name] = array_shift($cases)?->value;
                continue;
            }

            $data[$property->name] = self::randomScalarOf($typeName);
        }

        return $data;
    }


    /**
     * @param string $class
     * @param bool $isNullable
     * @return bool
     */
    protected function shouldInstantiate(string $class, bool $isNullable): bool
    {
        return class_exists($class) &&
            (!in_array($class, $this->resolveStack, true) || !$isNullable) &&
            !enum_exists($class);
    }


    /**
     * @param mixed $what
     * @param int $layer
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
     * @param string $type
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
     * @param int $length
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
     * @param int $min
     * @param int|null $max
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

    /**
     * @param string $class
     * @return ReflectionClass
     * @throws ReflectionException
     */
    private function getReflectionClass(string $class, array $context = []): ReflectionClass
    {
        $reflectionClass = new ReflectionClass($class);

        if ($reflectionClass->isAbstract()) {
            /** @var ConcreteResolver $resolver */
            $resolver = $this->hydrator->getConcreteFor($reflectionClass->getName());

            try {
                return new ReflectionClass($resolver?->concreteFor($context));
            } catch (Throwable) {
                $concretes = $resolver?->getConcretes();
                if (!empty($concretes)) {
                    return new ReflectionClass(array_shift($concretes));
                }
            }
        }
        return $reflectionClass;
    }

    private function fakeArray(ArrayType $arrayType, array $userDefined = [], $depth = 1): array
    {
        $wrapped = [];
        foreach ($userDefined as $layer) {
            if ($depth < $arrayType->depth) {
                $wrapped[] = $this->fakeArray($arrayType, $layer, $depth + 1);
            } else {
                $wrapped[] = $this->fakeDataFor($arrayType->class, $layer);
            }
        }

        if (empty($wrapped)) {
            $wrapped = $this->wrap(
                $this->fakeDataFor($arrayType->class, $userDefined),
                $arrayType->depth
            );
        }

        return $wrapped;
    }
}
