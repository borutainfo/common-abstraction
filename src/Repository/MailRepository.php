<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Repository;


use Boruta\CommonAbstraction\Entity\MailMessageEntity;
use Boruta\CommonAbstraction\Exception\RepositoryException;
use Boruta\CommonAbstraction\Gateway\MailGatewayInterface;

/**
 * Class MailRepository
 * @package Boruta\CommonAbstraction\Repository
 */
class MailRepository implements MailRepositoryInterface
{
    /**
     * @var MailGatewayInterface
     */
    private $gateway;

    /**
     * MailRepository constructor.
     * @param MailGatewayInterface $gateway
     */
    public function __construct(MailGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * @param MailMessageEntity $entity
     * @throws RepositoryException
     */
    public function send(MailMessageEntity $entity): void
    {
        $result = $this->gateway->send($entity->getSenderAddress()->value(), $entity->getSenderName()->value(),
            $entity->getSubject()->value(), $entity->getMessageHtml()->value(), $entity->getReceivers()->toArray());

        if (!$result) {
            throw new RepositoryException('Unable to send email.');
        }
    }
}
