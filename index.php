<?php


use Gutenisse\PhpOrmLite\PhpOrmLite;

require __DIR__."/vendor/autoload.php";

/**
 * Make sure you have edited the configuration file conf.json in your
 * root folder and set your database options.
 *
 * Create an instance of PhpOrmLite.
 */
$orm = new PhpOrmLite();

/**
 * To write actual model class files for each table in your database,
 * call the writeModels() function with the optional bool parameter
 * $overWrite to indicate whether or not to overwrite existing
 * model file.
 * $overWrite is false by default
 */
$orm->writeModels();

/**
 * Call getTables() to get an array of Table objects representing
 * the tables in your database.
 */
$tables = $orm->getTables();
foreach ($tables as $table) {
    echo "{$table->getName()}<br>";
}