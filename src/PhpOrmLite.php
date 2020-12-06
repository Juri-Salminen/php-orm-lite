<?php


namespace Gutenisse\PhpOrmLite;


use Gutenisse\PhpOrmLite\Db\Table;
use PDO;

class PhpOrmLite
{
    private DependencyContainer $dc;
    private array $tables = [];
    
    public function __construct(DependencyContainer $dc)
    {
        $this->dc = $dc;
    }
    
    private function getTable(string $name) : Table
    {
        return new Table($this->dc->getPdo(), $name);
    }
    
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
        $result = $this->dc->getPdo()->query("SHOW TABLES;");
        $result->execute();
    
        foreach ($result->fetchAll(PDO::FETCH_BOTH) as $row) {
            $this->tables[] = $this->getTable($row[0]);
        }

        return $this->tables;
    }
}