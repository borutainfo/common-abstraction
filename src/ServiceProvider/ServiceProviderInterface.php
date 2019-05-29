<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\ServiceProvider;


/**
 * Interface ServiceProviderInterface
 * @package Boruta\CommonAbstraction\ServiceProvider
 */
interface ServiceProviderInterface
{
    /**
     * @return void
     */
    public function register(): void;

    /* example:
    public function register(): void
    {
        DependencyInjector::set(MySQLConfig::class, function () {
            return new MySQLConfig(__DIR__ . '/../../config/mysql.yml');
        });

        DependencyInjector::set(LoggerInterface::class, FileLogger::class);

        ...
    }
    */
}
