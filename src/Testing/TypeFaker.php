<?php

namespace SergiX44\Nutgram\Testing;

use Faker\Factory;
use Faker\Generator;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionProperty;

class TypeFaker
{

    /**
     * @var Generator
     */
    private Generator $faker;

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @param  ContainerInterface  $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->faker = Factory::create();
        $this->container = $container;
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
    public function fakeFor(string $class, array $partial = []): mixed
    {
        $reflectionClass = new ReflectionClass($class);

        $instance = $this->container->get($class);
        $properties = $reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $property) {
            $typeName = $property->getType()?->getName();

            if (array_key_exists($property->name, $partial) && !is_array($partial[$property->name])) {
                $instance->{$property->name} = $partial[$property->name];
                continue;
            }

            if ($typeName === 'array') {
                $instance->{$property->name} = []; // TODO: handle array properly
                continue;
            }

            if ($property->getType()->allowsNull()) {
                continue;
            }

            if (class_exists($typeName)) {
                $instance->{$property->name} = $this->fakeFor($typeName, $partial[$property->name] ?? []);
                continue;
            }

            $instance->{$property->name} = match ($typeName) {
                'int' => $this->faker->numberBetween(),
                'string' => $this->faker->text(16),
                'bool' => $this->faker->boolean(),
                default => null
            };
        }
        return $instance;
    }
}
