<?php


namespace Gutenisse\PhpOrmLite;


use Gutenisse\PhpOrmLite\Db\Table;
use PDO;

class Factory
{
    private PDO $con;
    
    public function __construct(PDO $con)
    {
        $this->con = $con;
    }
    
    public function createTable(string $name) : Table
    {
        return new Table($this->con, $name);
    }
}