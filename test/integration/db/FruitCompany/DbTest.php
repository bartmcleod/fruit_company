<?php
declare(strict_types=1);

namespace FruitCompanyTest;

use FruitCompany\Config;
use PDO;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\Database\DefaultConnection;
use PHPUnit\DbUnit\Operation\Factory;
use PHPUnit\DbUnit\Operation\Operation;
use PHPUnit\DbUnit\TestCase;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Pdo as PdoDriver;
use Laminas\Db\Adapter\Platform\Mysql;

abstract class DbTest extends TestCase
{

    /**
     * @var PDO
     */
    private static $pdo;

    /**
     * @var Connection|DefaultConnection
     */
    private $conn;

    /**
     * @return Connection|DefaultConnection
     */
    final public function getConnection()
    {
        if (!is_null($this->conn)) {
            return $this->conn;
        }

        $dbParams = Config::get()['db'];

        $dsn = sprintf(
            'mysql:dbname=%s;host=%s;port=%d;charset=utf8',
            $database = $dbParams['database'] . '_test', // never use on a production db
            $host = $dbParams['host'],
            $port = $dbParams['port'],
        );

        if (self::$pdo === null) {
            self::$pdo = new PDO($dsn, $dbParams['username'], $dbParams['password']);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        $this->conn = $this->createDefaultDBConnection(self::$pdo, $database);

        return $this->conn;
    }

    /**
     * Returns the database operation executed in test cleanup.
     *
     * @return Operation
     */
    protected function getTearDownOperation(): Operation
    {
        return Factory::DELETE_ALL();
    }

    /**
     * Convenience method to get entity id by position in the dataset (1 based).
     * So the first entity is at $positionInDataset === 1.
     *
     * @param int $positionInDataset 1 based position in the dataset.
     * @return int
     */
    protected function getIdFromDataset(string $table, string $field, int $positionInDataset): int
    {
        // convert 1 based to zero based, because the dataset interface is zero based
        --$positionInDataset;
        return (int)$this->getDataSet()->getTable($table)->getValue($positionInDataset, $field);
    }

    protected function getDbAdapter(): Adapter
    {
        $driver = new PdoDriver($this->getConnection()->getConnection());
        $platform = new Mysql($driver);

        return new Adapter($driver, $platform, $queryResultPrototype = null, $profiler = null);
    }

}
