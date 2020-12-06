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
    
    /**
     * @param  int  $id
     * @param  string  $table
     *
     * @return mixed
     * @throws Exception
     */
    public static function get(int $id, string $table) : mixed
    {
        $stmt = PhpOrmLite::getDc()->getPdo()->prepare("SELECT * FROM {$table} WHERE id = :id;");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    
        if($stmt->rowCount() === 0) throw new Exception("The table '{$table}' does not contain a row with 'id' {$id}.");
        
        return $stmt->fetchAll(PDO::FETCH_CLASS, "Gutenisse\\PhpOrmLite\\Models\\". ucfirst($table))[0];
    }
    
    /**
     * @param  object  $entity
     * @param  string  $table
     *
     * @throws Exception
     */
    public static function save(object $entity, string $table) : void
    {
        $sql = "";
        
        if(empty($entity->id)) {
            foreach (get_object_vars($entity) as $propery => $value) {
                $columns[] = $propery;
                $values[] = ":{$propery}";
            }

            if(empty($columns) || empty($values)) throw new Exception("The entity model does not contain any properties.");

            $columString = implode(", ", $columns);
            $valueString = implode(", ", $values);
            
            $sql = "INSERT INTO {$table} ({$columString}) VALUES ({$valueString});";
            
            $stmt = PhpOrmLite::getDc()->getPdo()->prepare($sql);
    
            foreach (get_object_vars($entity) as $propery => $value) {
                $stmt->bindValue(":{$propery}", $value);
            }
        } else {
        
        }
        
        $stmt->execute();
    }
}