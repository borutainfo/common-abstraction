<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Config;


/**
 * Class LoggerConfig
 * @package Boruta\CommonAbstraction\Config
 */
class LoggerConfig extends ConfigAbstract
{
    protected const CONFIG_FILE_PATH = __DIR__ . '/../../config/logger.yml';
    /**
     * @var array
     */
    protected $requiredFields = ['path'];

    /**
     * @return string
     */
    public function getPath(): string
    {
        return (string)$this->getConfigData('path');
    }
}
