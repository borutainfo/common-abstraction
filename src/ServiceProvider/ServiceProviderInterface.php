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
        DependencyInjector::set(DatabaseConfig::class, function () {
            return new DatabaseConfig(__DIR__ . '/../../config/database.yml');
        });

        ...
    }
    */
}
