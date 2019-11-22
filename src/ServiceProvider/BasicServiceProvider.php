<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\ServiceProvider;


use Boruta\CommonAbstraction\DependencyInjector\DependencyInjector;
use Boruta\CommonAbstraction\Gateway\FileQueueGateway;
use Boruta\CommonAbstraction\Gateway\FileQueueGatewayInterface;
use Boruta\CommonAbstraction\Gateway\MailGateway;
use Boruta\CommonAbstraction\Gateway\MailGatewayInterface;
use Boruta\CommonAbstraction\Repository\FileQueueRepository;
use Boruta\CommonAbstraction\Repository\FileQueueRepositoryInterface;
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
        DependencyInjector::set(MailGatewayInterface::class, MailGateway::class);
        DependencyInjector::set(MailRepositoryInterface::class, MailRepository::class);
        DependencyInjector::set(FileQueueGatewayInterface::class, FileQueueGateway::class);
        DependencyInjector::set(FileQueueRepositoryInterface::class, FileQueueRepository::class);
    }
}
