<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Gateway;


use Boruta\CommonAbstraction\Config\DatabaseConfig;
use Boruta\CommonAbstraction\Exception\DatabaseConnectionException;
use PDO;
use PDOException;

/**
 * Class DatabaseGatewayAbstract
 * @package Boruta\CommonAbstraction\Gateway
 */
abstract class DatabaseGatewayAbstract
{
    /**
     * @var PDO
     */
    private $connection;
    /**
     * @var DatabaseConfig
     */
    private $databaseConfig;

    /**
     * AbstractDatabaseGateway constructor.
     * @param DatabaseConfig $databaseConfig
     */
    public function __construct(DatabaseConfig $databaseConfig)
    {
        $this->databaseConfig = $databaseConfig;
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    /**
     * @return PDO
     * @throws DatabaseConnectionException
     */
    protected function database(): PDO
    {
        $this->connect();
        return $this->connection;
    }

    /**
     * @throws DatabaseConnectionException
     */
    private function connect(): void
    {
        if ($this->connection instanceof PDO) {
            return;
        }

        try {
            $dsn = 'mysql:host=' . $this->databaseConfig->getHost() . ';dbname=' . $this->databaseConfig->getDatabase();
            $this->connection = new PDO($dsn, $this->databaseConfig->getLogin(), $this->databaseConfig->getPassword());
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        } catch (PDOException $exception) {
            throw new DatabaseConnectionException($exception->getMessage());
        }
    }

    private function disconnect(): void
    {
        if (!$this->connection instanceof PDO) {
            return;
        }

        $this->connection = null;
    }

    /**
     * @param array $data
     * @param string $table
     * @param bool $ignore
     * @return null|int
     */
    protected function insert(array $data, string $table, bool $ignore = false): ?int
    {
        $insertFields = implode(array_keys($data), ', ');
        $bindParams = implode(array_fill(0, \count($data), '?'), ', ');
        $query = 'INSERT' . ($ignore ? ' IGNORE' : '') . ' INTO ' . $table . ' (' . $insertFields . ') VALUES (' . $bindParams . ')';
        $stmt = $this->database()->prepare($query);
        if (!$stmt->execute(array_values($data))) {
            return null;
        }
        $id = (int)$this->database()->lastInsertId();
        return $id <= 0 ? 0 : $id;
    }

    /**
     * @param array $data
     * @param string $table
     * @param bool $ignore
     * @return bool
     */
    protected function insertMultiple(array $data, string $table, bool $ignore = false): bool
    {
        if (!is_array($data) || empty($data) || !array_key_exists(0, $data)) {
            return false;
        }

        $dataToInsert = [];
        foreach ($data as $singleData) {
            foreach ($singleData as $value) {
                $dataToInsert[] = $value;
            }
        }

        $insertFields = implode(array_keys($data[0]), ', ');

        $rowPlaces = '(' . implode(', ', array_fill(0, \count($data[0]), '?')) . ')';
        $bindParams = implode(', ', array_fill(0, \count($data), $rowPlaces));

        $query = 'INSERT' . ($ignore ? ' IGNORE' : '') . ' INTO ' . $table . ' (' . $insertFields . ') VALUES ' . $bindParams;
        $stmt = $this->database()->prepare($query);

        return $stmt->execute(array_values($dataToInsert));
    }

    /**
     * @param string $key
     * @param string $unique
     * @param string $table
     * @return array|null
     */
    protected function getSingleDataByUnique(string $key, string $unique, string $table): ?array
    {
        $query = 'SELECT * FROM ' . $table . ' WHERE ' . $key . ' = ? LIMIT 1';
        $stmt = $this->database()->prepare($query);

        if (!$stmt->execute([$unique])) {
            return null;
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!\is_array($result)) {
            return null;
        }

        return $result;
    }

    /**
     * @param string $condition
     * @param string $table
     * @return array|null
     */
    protected function getSingleDataByCondition(string $condition, string $table): ?array
    {
        $query = 'SELECT * FROM ' . $table . ' WHERE ' . $condition . ' LIMIT 1';
        $stmt = $this->database()->prepare($query);

        if (!$stmt->execute()) {
            return null;
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!\is_array($result)) {
            return null;
        }

        return $result;
    }
}
