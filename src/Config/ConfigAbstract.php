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
     * @var string
     */
    protected $configPath;
    /**
     * @var array
     */
    protected $requiredFields = [];

    /**
     * ConfigAbstract constructor.
     * @param string|null $configPath
     */
    public function __construct(string $configPath = null)
    {
        if ($configPath !== null) {
            $this->configPath = $configPath;
        }

        if ($this->configPath === null) {
            throw new ConfigException('No config path.');
        }

        if (!file_exists($this->configPath)) {
            throw new ConfigException('Unable to find config file: ' . $this->configPath);
        }

        try {
            $this->configData = (array)Yaml::parseFile($this->configPath);
        } catch (ParseException $exception) {
            throw new ConfigException('Unable to parse config file: ' . $this->configPath);
        }

        foreach ($this->requiredFields as $requiredField) {
            if (!array_key_exists($requiredField, $this->configData)) {
                throw new ConfigException('Config not contain required field `' . $requiredField . '`:' . $this->configPath);
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
            return $this->configData[$field] ?? null;
        }

        return $this->configData;
    }
}
