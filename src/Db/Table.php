<?php


namespace Gutenisse\PhpOrmLite\Db;


use Gutenisse\PhpOrmLite\PhpOrmLite;

class Table
{
    private array $columns = [];
    
    /**
     * Table constructor.
     *
     * @param  string  $name
     */
    public function __construct(private string $name)
    {
        $stmt = PhpOrmLite::getDc()->getPdo()->query("DESCRIBE {$name};");
        $stmt->execute();
        
        foreach ($stmt->fetchAll() as $row) {
            $this->columns[] = new Column($row);
        }
    }
    
    /**
     * Returns the actual name of the table.
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }
    
    /**
     * Returns all the columns in the table.
     *
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
     * Writes a Model class file in the Models folder. Per default existing
     * files will be skipped. Set $overWrite to true if you want to overwrite
     * existing files. Please note that any changes you made to the Model files
     * will we gone as the files are fully replaced by new files.
     *
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