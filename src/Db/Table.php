<?php


namespace Gutenisse\PhpOrmLite\Db;


use PDO;

class Table
{
    private PDO $con;
    private string $name;
    private array $columns = [];
    
    public function __construct(PDO $con, string $name, bool $overWrite = true)
    {
        $this->con = $con;
        $this->name = $name;
        
        $stmt = $con->query("DESCRIBE {$name};");
        $stmt->execute();
        
        foreach ($stmt->fetchAll() as $row) {
            $this->columns[] = new Column($row);
        }
        
        $this->writeModelClass($overWrite);
    }
    
    /**
     * @return string
     */
    public function getName() : string
    {
        $name = mb_strtolower($this->name);
        
        return ucfirst($name);
    }
    
    /**
     * @return Column[]
     */
    public function getColumns() : array
    {
        return $this->columns;
    }
    
    private function getUcaseFirst(string $string) : string
    {
        $string = mb_strtolower($string);
        return ucfirst($string);
    }
 
    private function getLowercase(string $string) : string
    {
        return mb_strtolower($string);
    }
    
    private function getType(Column $column) : string
    {
        return $column->isNumeric() ? "int" : "string";
    }
    
    private function writeModelClass(bool $overWrite) : void
    {
        $class = "<?php


class {$this->getName()}
{\n";
        
        foreach ($this->getColumns() as $column) {
            $class .= "\tprivate {$this->getType($column)} \${$this->getLowercase($column->getName())};\n";
        }
        
        $class .= "\n";
        
        foreach ($this->getColumns() as $column) {
            $type = $column->isNumeric() ? "int" : "string";
            $class .= "\tpublic function get{$this->getUcaseFirst($column->getName())}() : {$type}\n";
            $class .= "\t{\n";
            $class .= "\t\treturn \$this->{$this->getLowercase($column->getName())};\n";
            $class .= "\t}\n\n";
        }
        
        $class .= "}";
        
        if($overWrite) {
            file_put_contents(__DIR__."/../../Models/{$this->getName()}.php", $class);
        } else {
            if( ! file_exists(__DIR__."/../../Models/{$this->getName()}.php")) {
                file_put_contents(__DIR__."/../../Models/{$this->getName()}.php", $class);
            }
        }
    }
}