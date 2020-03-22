<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Config;

/**
 * Class MailConfig
 * @package Boruta\CommonAbstraction\Config
 * @example mail.yml
 */
class MailConfig extends ConfigAbstract
{
    /**
     * @var array
     */
    protected $requiredFields = ['host', 'login', 'password'];

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
     * @return int
     */
    public function getPort(): int
    {
        return (int)$this->getConfigData('port') ?: 587;
    }

    /**
     * @return bool
     */
    public function getSmtpAuth(): bool
    {
        return (bool)$this->getConfigData('smtpAuth') ?: true;
    }
}
