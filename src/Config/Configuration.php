<?php


namespace Gutenisse\PhpOrmLite\Config;


use Exception;

class Configuration
{
    private DatabaseConfiguration $database;
    
    private function __construct()
    {
        $json = file_get_contents(__DIR__."/../conf.json");
    
        $config = json_decode($json);
    
        if( ! empty($config->database)) {
            $this->database = new DatabaseConfiguration(
                $config->database->type,
                $config->database->host,
                $config->database->user,
                $config->database->password,
                $config->database->database,
                $config->database->port
            );
        }
    }
    
    /**
     * @throws Exception
     */
    public static function load() : Configuration
    {
        if( ! file_exists(__DIR__."/../conf.json")) throw new Exception("The configuration file 'conf.json' is missing");
        
        return new Configuration();
    }
    
    /**
     * @return DatabaseConfiguration
     */
    public function getDbConfig() : DatabaseConfiguration
    {
        return $this->database;
    }
}