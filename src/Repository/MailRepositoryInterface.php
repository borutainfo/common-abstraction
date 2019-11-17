<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Repository;


use Boruta\CommonAbstraction\Entity\MailMessageEntity;
use Boruta\CommonAbstraction\Exception\RepositoryException;

/**
 * Interface MailRepositoryInterface
 * @package Boruta\CommonAbstraction\Repository
 */
interface MailRepositoryInterface
{
    /**
     * @param MailMessageEntity $entity
     * @throws RepositoryException
     */
    public function send(MailMessageEntity $entity): void;
}
