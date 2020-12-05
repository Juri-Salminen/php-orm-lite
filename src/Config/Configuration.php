<?php


namespace Gutenisse\PhpOrmLite\Config;


use Exception;

class Configuration
{
    private Database $database;
    
    /**
     * @throws Exception
     */
    public function __construct()
    {
        if( ! file_exists(__DIR__."/../../conf.json")) throw new Exception("The configuration file 'conf.json' is missing");
        
        $json = file_get_contents(__DIR__."/../../conf.json");
        
        $config = json_decode($json);
        
        if( ! empty($config->database)) {
            $this->database = new Database(
                $config->database->host,
                $config->database->user,
                $config->database->password,
                $config->database->database,
                $config->database->port
            );
        }
    }
    
    /**
     * @return Database
     */
    public function getDbConfig() : Database
    {
        return $this->database;
    }
}