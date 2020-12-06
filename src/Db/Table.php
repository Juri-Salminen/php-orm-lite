<?php


namespace Gutenisse\PhpOrmLite\Db;


use Gutenisse\PhpOrmLite\PhpOrmLite;

class Table
{
    private string $name;
    private array $columns = [];
    
    /**
     * Table constructor.
     *
     * @param  string  $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        
        $stmt = PhpOrmLite::getDc()->getPdo()->query("DESCRIBE {$name};");
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
    
    /**
     * @param  string  $string
     *
     * @return string
     */
    private function getUcaseFirst(string $string) : string
    {
        $string = strtolower($string);
        return ucfirst($string);
    }
    
    /**
     * @param  string  $string
     *
     * @return string
     */
    private function getLowercase(string $string) : string
    {
        return strtolower($string);
    }
    
    /**
     * @param  Column  $column
     *
     * @return string
     */
    private function getType(Column $column) : string
    {
        return $column->isNumeric() ? "int" : "string";
    }
    
    /**
     * @param  bool  $overWrite
     */
    public function writeModelClass(bool $overWrite) : void
    {
        if($overWrite === false && file_exists(__DIR__."/../Models/{$this->getUcaseFirst($this->getName())}.php")) {
            return;
        }
        
        require __DIR__."/../Templates/Model.php";
    
        if( ! file_exists(__DIR__."/../Models")) {
            mkdir(__DIR__."/../Models");
        }
        
        file_put_contents(__DIR__."/../Models/{$this->getUcaseFirst($this->getName())}.php", $class);
    }
}