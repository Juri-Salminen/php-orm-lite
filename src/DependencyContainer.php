<?php


namespace Gutenisse\PhpOrmLite;


use PDO;

class DependencyContainer
{
    private PDO $pdo;
    
    /**
     * @return PDO
     */
    public function getPdo() : PDO
    {
        return $this->pdo;
    }
    
    /**
     * @param  PDO  $pdo
     */
    public function setPdo(PDO $pdo) : void
    {
        $this->pdo = $pdo;
    }
}