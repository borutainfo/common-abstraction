<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Gateway;


use Boruta\CommonAbstraction\Config\FileQueueConfig;
use Throwable;

/**
 * Class FileQueueGateway
 * @package Boruta\CommonAbstraction\Gateway
 */
class FileQueueGateway implements FileQueueGatewayInterface
{
    private const FILE_EXTENSION = '.queue';

    /**
     * @var FileQueueConfig
     */
    private $config;

    /**
     * FileQueueGateway constructor.
     * @param FileQueueConfig $config
     */
    public function __construct(FileQueueConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function push(string $key, $value): bool
    {
        if ($value === null) {
            return false;
        }

        try {
            $queueDir = rtrim($this->config->getPath(), '/') . '/';
            $queueFile = $queueDir . '/' . $key . static::FILE_EXTENSION;

            if (!is_writable($queueDir) || (file_exists($queueFile) && !is_writable($queueFile))) {
                return false;
            }

            $messageToSave = base64_encode(serialize($value));

            return (bool)file_put_contents($queueFile, $messageToSave . PHP_EOL, FILE_APPEND | LOCK_EX);
        } catch (Throwable $exception) {
            return false;
        }
    }

    /**
     * @param string $key
     * @param array $values
     * @return bool
     */
    public function pushMultiple(string $key, array $values): bool
    {
        foreach ($values as $value) {
            if ($value === null) {
                return false;
            }
        }

        try {
            $queueDir = rtrim($this->config->getPath(), '/') . '/';
            $queueFile = $queueDir . '/' . $key . static::FILE_EXTENSION;

            if (!is_writable($queueDir) || (file_exists($queueFile) && !is_writable($queueFile))) {
                return false;
            }

            $messageToSave = '';
            foreach ($values as $value) {
                $messageToSave .= base64_encode(serialize($value)) . PHP_EOL;
            }

            return (bool)file_put_contents($queueFile, $messageToSave, FILE_APPEND | LOCK_EX);
        } catch (Throwable $exception) {
            return false;
        }
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function pop(string $key)
    {
        try {
            $queueDir = rtrim($this->config->getPath(), '/') . '/';
            $queueFile = $queueDir . '/' . $key . static::FILE_EXTENSION;

            if (!is_readable($queueDir) || !file_exists($queueFile) || !is_readable($queueFile)) {
                return null;
            }

            $firstLine = null;
            if ($handle = fopen($queueFile, 'cb+')) {
                if (flock($handle, LOCK_EX)) {
                    while (($line = fgets($handle, 4096)) !== false) {
                        if ($firstLine === null) {
                            $firstLine = $line;
                        }

                        if (!isset($writePosition)) {
                            $writePosition = 0;
                        } else {
                            $readPosition = ftell($handle);
                            fseek($handle, $writePosition);
                            fwrite($handle, $line);
                            fseek($handle, $readPosition);
                            $writePosition += strlen($line);
                        }
                    }

                    fflush($handle);

                    if (isset($writePosition)) {
                        ftruncate($handle, $writePosition);
                    }

                    flock($handle, LOCK_UN);
                }
                fclose($handle);
            }

            if ($firstLine === null) {
                return null;
            }

            /** @noinspection UnserializeExploitsInspection - storing object on the queue is risk-aware */
            return unserialize(base64_decode($firstLine));
        } catch (Throwable $exception) {
            if (isset($handle)) {
                @flock($handle, LOCK_UN);
                @fclose($handle);
            }
            return null;
        }
    }
}
