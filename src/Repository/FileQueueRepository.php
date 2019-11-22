<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Repository;


use Boruta\CommonAbstraction\Exception\RepositoryException;
use Boruta\CommonAbstraction\Gateway\FileQueueGatewayInterface;
use Boruta\CommonAbstraction\ValueObject\QueueName;

/**
 * Class FileQueueRepository
 * @package Boruta\CommonAbstraction\Repository
 */
class FileQueueRepository implements FileQueueRepositoryInterface
{
    /**
     * @var FileQueueGatewayInterface
     */
    private $gateway;

    /**
     * FileQueueRepository constructor.
     * @param FileQueueGatewayInterface $gateway
     */
    public function __construct(FileQueueGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * @param QueueName $key
     * @param mixed $value
     * @throws RepositoryException
     */
    public function push(QueueName $key, $value): void
    {
        if (!$this->gateway->push($key->value(), $value)) {
            throw new RepositoryException('Unable to push value.');
        }
    }

    /**
     * @param QueueName $key
     * @param array $values
     * @throws RepositoryException
     */
    public function pushMultiple(QueueName $key, array $values): void
    {
        if (!$this->gateway->pushMultiple($key->value(), $values)) {
            throw new RepositoryException('Unable to push values.');
        }
    }

    /**
     * @param QueueName $key
     * @return mixed
     */
    public function pop(QueueName $key)
    {
        $value = $this->gateway->pop($key->value());

        if ($value === null) {
            throw new RepositoryException('Unable to pop value.');
        }

        return $value;
    }
}
