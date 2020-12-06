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
     * @return int
     * @throws Exception
     */
    public static function save(object $entity, string $table) : int
    {
        if(empty($entity->id)) {
            return self::insert($entity, $table);
        } else {
            return self::update($entity, $table);
        }
    }
    
    /**
     * @param  object  $entity
     * @param  string  $table
     *
     * @return int
     * @throws Exception
     */
    private static function insert(object $entity, string $table) : int
    {
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
    
        try {
            $stmt->execute();
            return self::getId($table);
        }
        catch(Exception $exception) {
            if($exception->getCode() == 23000) {
                return self::update($entity, $table);
            }
            
            throw $exception;
        }
    }
    
    /**
     * @param  object  $entity
     * @param  string  $table
     *
     * @return int
     * @throws Exception
     */
    private static function update(object $entity, string $table) : int
    {
        foreach (get_object_vars($entity) as $propery => $value) {
            if( ! empty($value)) {
                $columns[] = "{$propery} = :{$propery}";
            }
        }
        
        if(empty($columns)) throw new Exception("The entity model does not contain any properties.");
    
        $columString = implode(", ", $columns);
    
        $sql = "UPDATE {$table} SET {$columString} WHERE id = :id;";
        
        $stmt = PhpOrmLite::getDc()->getPdo()->prepare($sql);
    
        foreach (get_object_vars($entity) as $propery => $value) {
            if( ! empty($value)) {
                $stmt->bindValue(":{$propery}", $value);
            }
        }
    
        try {
            $stmt->execute();
            return self::getId($table);
        }
        catch(Exception $exception) {
            throw $exception;
        }
    }
    
    private static function getId(string $table) : int
    {
        return PhpOrmLite::getDc()->getPdo()->query("SELECT id FROM {$table} WHERE id = LAST_INSERT_ID();")->fetchColumn();
    }
}