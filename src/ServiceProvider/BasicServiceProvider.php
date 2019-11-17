<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\ServiceProvider;


use Boruta\CommonAbstraction\DependencyInjector\DependencyInjector;
use Boruta\CommonAbstraction\Gateway\MailGateway;
use Boruta\CommonAbstraction\Gateway\MailGatewayInterface;
use Boruta\CommonAbstraction\Repository\MailRepository;
use Boruta\CommonAbstraction\Repository\MailRepositoryInterface;

/**
 * Class BasicServiceProvider
 * @package Boruta\CommonAbstraction\ServiceProvider
 */
class BasicServiceProvider implements ServiceProviderInterface
{
    /**
     * @return void
     */
    public function register(): void
    {
        DependencyInjector::set(MailRepositoryInterface::class, MailRepository::class);
        DependencyInjector::set(MailGatewayInterface::class, MailGateway::class);
    }
}
