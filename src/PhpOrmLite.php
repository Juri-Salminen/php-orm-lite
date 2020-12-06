<?php


namespace Gutenisse\PhpOrmLite;


use Gutenisse\PhpOrmLite\Db\Table;
use PDO;

class PhpOrmLite
{
    private static DependencyContainer $dc;
    private array $tables = [];
    
    public function __construct(DependencyContainer $dc)
    {
        self::$dc = $dc;
    }
    
    /**
     * @return DependencyContainer
     */
    public static function getDc() : DependencyContainer
    {
        return self::$dc;
    }
    
    /**
     * @param  string  $name
     *
     * @return Table
     */
    private function getTable(string $name) : Table
    {
        return new Table($name);
    }
    
    /**
     * @param  bool  $overWrite
     */
    public function writeModels(bool $overWrite = false) : void
    {
        foreach ($this->getTables() as $table) {
            $table = $this->getTable($table->getName());
            $table->writeModelClass($overWrite);
            $this->tables[] = $table;
        }
    }
    
    /**
     * @return Table[]
     */
    public function getTables() : array
    {
        $this->tables = [];
        $result = self::$dc->getPdo()->query("SHOW TABLES;");
        $result->execute();
    
        foreach ($result->fetchAll(PDO::FETCH_BOTH) as $row) {
            $this->tables[] = $this->getTable($row[0]);
        }

        return $this->tables;
    }
}