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
    public function __construct(string $host, string $user, string $password, string $database, int $port)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;
    }
    
    /**
     * @return string
     */
    public function getHost() : string
    {
        return $this->host;
    }
    
    /**
     * @return string
     */
    public function getUser() : string
    {
        return $this->user;
    }
    
    /**
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }
    
    /**
     * @return string
     */
    public function getDatabase() : string
    {
        return $this->database;
    }
    
    /**
     * @return int
     */
    public function getPort() : int
    {
        return $this->port;
    }
}