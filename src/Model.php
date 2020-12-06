<?php


namespace Gutenisse\PhpOrmLite;


class Model
{
    public static function list(string $table)
    {
        $result = self::$pdo->query("SELECT * FROM ". self::$_tableName .";");
        if($result->rowCount() === 0) throw new Exception("The table '". self::$_tableName ."' has no records.");
        
        $entities = [];
        foreach ($result->fetchAll(PDO::FETCH_CLASS) as $row) {
            $entities[] = $row;
        }
        
        return $entities;
    }
}