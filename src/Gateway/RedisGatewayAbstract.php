<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Gateway;


use Boruta\CommonAbstraction\Config\RedisConfig;
use Predis\Client;

/**
 * Class RedisGatewayAbstract
 * @package Boruta\CommonAbstraction\Gateway
 */
abstract class RedisGatewayAbstract
{
    /**
     * @var Client
     */
    private $client;

    /**
     * RedisGatewayAbstract constructor.
     * @param RedisConfig $config
     */
    public function __construct(RedisConfig $config)
    {
        $parameters = [
            'scheme' => 'tcp',
            'host' => $config->getHost(),
            'port' => $config->getPort(),
        ];

        $options = [
            'parameters' => [
                'password' => $config->getPassword(),
                'database' => $config->getDatabase(),
            ],
        ];

        $this->client = new Client($parameters, $options);
    }

    // keys:

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    protected function setKeyIfNotExists(string $key, string $value): bool
    {
        return $this->client->setnx($key, $value) === 1;
    }

    // sets:

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    protected function addToSeIfNotExists(string $key, string $value): bool
    {
        return (bool)$this->client->sadd($key, [$value]);
    }

    // hash:

    /**
     * @param string $key
     * @param string $field
     * @param string $value
     * @return bool
     */
    protected function addToHash(string $key, string $field, string $value): bool
    {
        return (bool)$this->client->hset($key, $field, $value);
    }

    // lists:

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    protected function pushToList(string $key, string $value): bool
    {
        return $this->client->rpush($key, [$value]) > 0;
    }

    /**
     * @param string $key
     * @return string|null
     */
    protected function popFromList(string $key): ?string
    {
        return $this->client->lpop($key);
    }
}
