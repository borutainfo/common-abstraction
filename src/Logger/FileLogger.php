<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Logger;


use Boruta\CommonAbstraction\Config\LoggerConfig;
use Psr\Log\LoggerInterface;

/**
 * Class FileLogger
 * @package Boruta\CommonAbstraction\Logger
 */
class FileLogger implements LoggerInterface
{
    private const BASE_PATH = __DIR__ . '/../../../../../';

    /**
     * @var LoggerConfig
     */
    private $config;

    /**
     * FileLogger constructor.
     * @param LoggerConfig $config
     */
    public function __construct(LoggerConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $logType
     * @param string $message
     * @param $context
     */
    protected function logToFile(string $logType, string $message, array $context): void
    {
        $filename = $logType . '_' . date('Y-m-d') . '.txt';

        $content = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
        if (!empty($content)) {
            $content .= print_r($context, true) . PHP_EOL;
        }

        file_put_contents(self::BASE_PATH . trim($this->config->getPath(), '/') . '/' . $filename,
            $content, FILE_APPEND);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function emergency($message, array $context = array()): void
    {
        $this->logToFile('emergency', $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function alert($message, array $context = array()): void
    {
        $this->logToFile('alert', $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function critical($message, array $context = array()): void
    {
        $this->logToFile('critical', $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function error($message, array $context = array()): void
    {
        $this->logToFile('error', $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function warning($message, array $context = array()): void
    {
        $this->logToFile('warning', $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function notice($message, array $context = array()): void
    {
        $this->logToFile('notice', $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function info($message, array $context = array()): void
    {
        $this->logToFile('info', $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function debug($message, array $context = array()): void
    {
        $this->logToFile('debug', $message, $context);
    }

    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     */
    public function log($level, $message, array $context = array()): void
    {
        $this->logToFile('log', $message, $context);
    }
}
