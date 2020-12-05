<?php


namespace Gutenisse\PhpOrmLite\Db;


use PDO;

class Table
{
    private PDO $con;
    private string $name;
    private array $columns = [];
    
    public function __construct(PDO $con, string $name)
    {
        $this->con = $con;
        $this->name = $name;
        
        $stmt = $con->query("DESCRIBE {$name};");
        $stmt->execute();
        
        foreach ($stmt->fetchAll() as $row) {
            $this->columns[] = new Column($row);
        }
    }
    
    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }
    
    /**
     * @return Column[]
     */
    public function getColumns() : array
    {
        return $this->columns;
    }
}