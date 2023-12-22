<?php
declare(strict_types=1);

namespace RecipeManager;

use League\Container\Container;
use League\Container\ReflectionContainer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

final class ContainerHandler
{
    private static ?Container $container = null;

    /**
     * @template T
     * @param class-string<T> $class
     * @return T
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function Get(string $class): mixed {
        $container = self::GetContainer();
        return $container->get($class);
    }

    /**
     * @template T
     * @param class-string<T> $class
     * @return T
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function GetNew(string $class): mixed {
        $container = self::GetContainer();
        return $container->getNew($class);
    }

    public static function GetContainer(): Container
    {
        if (self::$container === null) {
            self::createContainer();
        }

        return self::$container;
    }

    private static function createContainer() {
        if (self::$container !== null) {
            return;
        }

        self::$container = new Container();
        self::$container->delegate(
            new ReflectionContainer(true)
        );
    }
}