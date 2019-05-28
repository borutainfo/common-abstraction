<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\DependencyInjector;


use Boruta\CommonAbstraction\Exception\DependencyInjectorException;
use Boruta\CommonAbstraction\ServiceProvider\ServiceProviderInterface;
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
    private static function getContainer(): Container
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
                        return null; // unable to create one of sub-dependencies
                    }
                }

                $closure = function () use ($class, $dependencies, $container) {
                    foreach ($dependencies as &$param) {
                        if (!is_string($param)) {
                            continue;
                        }

                        if ($container->offsetExists($param)) {
                            $param = $container->offsetGet($param);
                        } elseif (class_exists($param)) {
                            $param = self::get($param);
                        } elseif (interface_exists($param)) {
                            $implementingClasses = self::getImplementingClasses($param);
                            if (count($implementingClasses) === 1) {
                                $param = self::get($implementingClasses[0]);
                            } else {
                                throw new DependencyInjectorException('Unable to find implementation for: ' . $param);
                            }
                        }
                    }
                    return $class->newInstanceArgs($dependencies);
                };
            }

            $container->offsetSet($id, $container->factory($closure));
            return $container->offsetGet($id);
        } catch (DependencyInjectorException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            throw new DependencyInjectorException('Unable to create dependency: ' . $id);
        }
    }

    /**
     * @param string $key
     * @param $value
     * @return bool
     */
    public static function set(string $key, $value): bool
    {
        try {
            if (is_callable($value)) {
                self::getContainer()->offsetSet($key, $value);
            } elseif (is_string($value)) {
                self::getContainer()->offsetSet($key, function () use ($value) {
                    return self::get($value);
                });
            }
        } catch (FrozenServiceException $exception) {
            return false;
        }

        return true;
    }

    /**
     * @param $serviceProviders
     * @return bool
     */
    public static function register($serviceProviders): bool
    {
        if (is_string($serviceProviders)) {
            /** @var ServiceProviderInterface $serviceProviderInstance */
            $serviceProviderInstance = self::get($serviceProviders);
            $serviceProviderInstance->register();
            return true;
        }

        if (is_array($serviceProviders)) {
            $result = true;
            foreach ($serviceProviders as $serviceProvider) {
                $result = $result && self::register($serviceProvider);
            }
            return $result;
        }

        return false;
    }

    /**
     * @param string $interfaceName
     * @return array
     */
    private static function getImplementingClasses(string $interfaceName): array
    {
        return array_filter(get_declared_classes(), function ($className) use ($interfaceName) {
            return in_array($interfaceName, class_implements($className), true);
        });
    }
}
