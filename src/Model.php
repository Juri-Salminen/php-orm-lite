<?php


namespace Gutenisse\PhpOrmLite;


use Exception;
use PDO;

class Model
{
    /**
     * @param  string  $table
     *
     * @return array
     * @throws Exception
     */
    public static function list(string $table) : array
    {
        $result = PhpOrmLite::getDc()->getPdo()->query("SELECT * FROM {$table};");
        if($result->rowCount() === 0) throw new Exception("The table '{$table}' has no records.");
        
        $entities = [];
        foreach ($result->fetchAll(PDO::FETCH_CLASS, "Gutenisse\\PhpOrmLite\\Models\\". ucfirst($table)) as $row) {
            $entities[] = $row;
        }
        
        return $entities;
    }
}