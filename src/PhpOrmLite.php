<?php


namespace Gutenisse\PhpOrmLite;


use Exception;
use Gutenisse\PhpOrmLite\Config\Configuration;
use Gutenisse\PhpOrmLite\Db\Table;
use PDO;

class PhpOrmLite
{
    private Configuration $configuration;
    private PDO $con;
    
    /**
     * PhpOrmLite constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        try {
            $this->configuration = Configuration::load();
        } catch (Exception $exception) {
            throw $exception;
        }
    
        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
    
        $this->con = new PDO(
            "mysql:host={$this->configuration->getDbConfig()->getHost()};dbname={$this->configuration->getDbConfig()->getDatabase()};port={$this->configuration->getDbConfig()->getPort()};charset=utf8mb4",
            $this->configuration->getDbConfig()->getUser(),
            $this->configuration->getDbConfig()->getPassword(),
            $options
        );
    }
    
    public function getTables(string $name, bool $overWrite = true) : Table
    {
        return new Table($this->con, $name, $overWrite);
    }
}