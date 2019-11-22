<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Gateway;


/**
 * Interface FileQueueGatewayInterface
 * @package Boruta\CommonAbstraction\Gateway
 */
interface FileQueueGatewayInterface
{
    /**
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function push(string $key, $value): bool;

    /**
     * @param string $key
     * @param array $values
     * @return bool
     */
    public function pushMultiple(string $key, array $values): bool;

    /**
     * @param string $key
     * @return mixed
     */
    public function pop(string $key);
}
