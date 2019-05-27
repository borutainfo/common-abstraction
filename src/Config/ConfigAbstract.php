<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Config;


use Boruta\CommonAbstraction\Exception\ConfigException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ConfigAbstract
 * @package Boruta\CommonAbstraction\Config
 */
abstract class ConfigAbstract
{
    /**
     * @var array
     */
    private $configData;
    /**
     * @var array
     */
    protected $requiredFields = [];

    /**
     * ConfigAbstract constructor.
     * @param string $configPath
     */
    protected function __construct(string $configPath)
    {
        try {
            $this->configData = (array)Yaml::parseFile($configPath);
        } catch (ParseException $exception) {
            throw new ConfigException('Unable to parse config file: ' . $configPath);
        }

        foreach ($this->requiredFields as $requiredField) {
            if (!array_key_exists($requiredField, $this->configData)) {
                throw new ConfigException('Config not contain required field `' . $requiredField . '`:' . $configPath);
            }
        }
    }

    /**
     * @param string|null $field
     * @return mixed
     */
    protected function getConfigData(string $field = null)
    {
        if ($field !== null) {
            return $this->configData[$field];
        }

        return $this->configData;
    }
}
