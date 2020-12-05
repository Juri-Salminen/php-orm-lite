<?php


namespace Gutenisse\PhpOrmLite\Config;


use Exception;

class Configuration
{
    private static Database $database;
    
    /**
     * @return Configuration
     * @throws Exception
     */
    public static function create() : Configuration
    {
        if( ! file_exists(__DIR__."/../../conf.json")) throw new Exception("The configuration file 'conf.json' is missing");
        
        $json = file_get_contents(__DIR__."/../../conf.json");
        
        $config = json_decode($json);
        
        if( ! empty($config->database)) {
            self::createDatabaseConfiguration($config->database);
        }
        
        return new Configuration();
    }
    
    private static function createDatabaseConfiguration(object $config) : void
    {
        self::$database = Database::create($config->host, $config->user, $config->password, $config->database, $config->port);
    }
}