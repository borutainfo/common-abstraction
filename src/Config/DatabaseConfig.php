<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Config;


/**
 * Class DatabaseConfig
 * @package Boruta\CommonAbstraction\Config
 */
class DatabaseConfig extends ConfigAbstract
{
    protected const CONFIG_FILE_PATH = __DIR__ . '/../../config/database.yml';
    /**
     * @var array
     */
    protected $requiredFields = ['host', 'login', 'password', 'database'];

    /**
     * @return string
     */
    public function getHost(): string
    {
        return (string)$this->getConfigData('host');
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return (string)$this->getConfigData('login');
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return (string)$this->getConfigData('password');
    }

    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return (string)$this->getConfigData('database');
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return (int)$this->getConfigData('port') ?: 3306;
    }
}
