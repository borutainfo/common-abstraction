<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Config;


/**
 * Class FileQueueConfig
 * @package Boruta\CommonAbstraction\Config
 */
class FileQueueConfig extends ConfigAbstract
{
    protected const CONFIG_FILE_PATH = __DIR__ . '/../../config/file-queue.yml';

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
