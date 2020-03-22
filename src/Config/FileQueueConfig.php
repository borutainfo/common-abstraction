<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Config;


/**
 * Class FileQueueConfig
 * @package Boruta\CommonAbstraction\Config
 * @example file-queue.yml
 */
class FileQueueConfig extends ConfigAbstract
{
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
