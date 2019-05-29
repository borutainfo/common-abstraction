<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Config;


/**
 * Class RedisConfig
 * @package Boruta\CommonAbstraction\Config
 */
class RedisConfig extends ConfigAbstract
{
    protected const CONFIG_FILE_PATH = __DIR__ . '/../../config/redis.yml';
    /**
     * @var array
     */
    protected $requiredFields = ['host'];

    /**
     * @return string
     */
    public function getHost(): string
    {
        return (string)$this->getConfigData('host');
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return (int)$this->getConfigData('port') ?: 6379;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->getConfigData('password') ? (string)$this->getConfigData('password') : null;
    }

    /**
     * @return int
     */
    public function getDatabase(): int
    {
        return (int)$this->getConfigData('database');
    }
}
