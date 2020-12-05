<?php


namespace Gutenisse\PhpOrmLite\Config;


class Database
{
    private string $host;
    private string $user;
    private string $password;
    private string $database;
    private int $port;
    
    /**
     * Database constructor.
     *
     * @param  string  $host
     * @param  string  $user
     * @param  string  $password
     * @param  string  $database
     * @param  int  $port
     */
    private function __construct(string $host, string $user, string $password, string $database, int $port)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;
    }
    
    public static function create(string $host, string $user, string $password, string $database, int $port) : Database
    {
        return new Database($host, $user, $password, $database, $port);
    }
}