<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Repository;


use Boruta\CommonAbstraction\Exception\RepositoryException;
use Boruta\CommonAbstraction\ValueObject\QueueName;

/**
 * Interface FileQueueRepositoryInterface
 * @package Boruta\CommonAbstraction\Repository
 */
interface FileQueueRepositoryInterface
{
    /**
     * @param QueueName $key
     * @param mixed $value
     * @throws RepositoryException
     */
    public function push(QueueName $key, $value): void;

    /**
     * @param QueueName $key
     * @param array $values
     * @throws RepositoryException
     */
    public function pushMultiple(QueueName $key, array $values): void;

    /**
     * @param QueueName $key
     * @return mixed
     * @throws RepositoryException
     */
    public function pop(QueueName $key);
}
