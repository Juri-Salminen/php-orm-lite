<?php


use Gutenisse\PhpOrmLite\Models\Products;
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
$tables = $orm->getTables(true);

// Iterate threw each table and print out each column
foreach ($tables as $table) {
    echo "{$table->getName()}<br>";
    
    // Iterate threw each column and print out it's properties
    foreach ($table->getColumns() as $column) {
        echo "&nbsp;&nbsp;- {$column->getName()} {$column->getType()}({$column->getLength()})<br>";
    }
}

/**
 * The main point of an ORM is to make CRUD-operations as easy as possible
 * and now it's time to show how that is done in PhpLiteOrm.
 */
$products = Products::class;