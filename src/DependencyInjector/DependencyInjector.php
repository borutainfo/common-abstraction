<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\DependencyInjector;


use Exception;
use Pimple\Container;
use Pimple\Exception\FrozenServiceException;
use ReflectionClass;

/**
 * Class DependencyInjector
 * @package Boruta\CommonAbstraction\DependencyInjector
 */
class DependencyInjector
{
    /**
     * @var Container
     */
    private static $container;

    /**
     * @return Container
     */
    protected static function getContainer(): Container
    {
        if (self::$container === null) {
            self::$container = new Container();
        }

        return self::$container;
    }

    /**
     * @param string $id
     * @return mixed
     */
    public static function get(string $id)
    {
        $container = self::getContainer();

        try {
            if ($container->offsetExists($id)) {
                return $container->offsetGet($id);
            }

            if (!class_exists($id)) {
                return null;
            }

            $class = new ReflectionClass($id);
            $constructor = $class->getConstructor();

            if (!$constructor) {
                $closure = function () use ($id) {
                    return new $id();
                };
            } else {
                $dependencies = [];

                foreach ($constructor->getParameters() as $parameter) {
                    if (($subClass = $parameter->getClass()) !== null) {
                        $dependencies[$parameter->getName()] = $subClass->name;
                    } elseif ($parameter->isDefaultValueAvailable()) {
                        $dependencies[$parameter->getName()] = $parameter->getDefaultValue();
                    } else {
                        return null; // unable to create one of subdependencies
                    }
                }

                $closure = function () use ($class, $dependencies) {
                    foreach ($dependencies as &$param) {
                        if (class_exists($param)) {
                            $param = self::get($param);
                        }
                    }
                    return $class->newInstanceArgs($dependencies);
                };
            }

            $container->offsetSet($id, $container->factory($closure));
            return $container->offsetGet($id);
        } catch (Exception $exception) {
            return null; // unable to create class instance
        }
    }

    /**
     * @param string $key
     * @param callable $callable
     * @return bool
     */
    public static function set(string $key, callable $callable): bool
    {
        try {
            self::getContainer()->offsetSet($key, $callable);
        } catch (FrozenServiceException $exception) {
            return false;
        }

        return true;
    }
}