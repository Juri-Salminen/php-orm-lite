<?php


use Gutenisse\PhpOrmLite\DependencyContainer;
use Gutenisse\PhpOrmLite\Models\Products;
use Gutenisse\PhpOrmLite\PhpOrmLite;

require __DIR__."/vendor/autoload.php";

/**
 * PhpOrmLite requires an active PDO instance, so we start by creating one.
 * The following PDO instance is configured to connect to a MySql database
 * hosted on 'localhost' with standard port 3306.
 * You should replace the host, port, username ond password to match your
 * database hosting configuration.
 */
$host     = "localhost"; // The hostname of your database server, i.e "db001.example.com", "localhost", "195.10.10.100" etc.
$database = "demo-db"; // The name of the database you want to connect to.
$port     = 3306; // The port number on which the databaser server is listening on.
$charset  = "utf8mb4"; // The charset to be used by the connection.

$pdo = new PDO(
    "mysql:host={$host};dbname={$database};port={$port};charset={$charset}",
    "demoUser",
    "demoPassword",
    [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]
);

/**
 * PhpOrmLite uses dependency injection by adding dependencies in to an
 * instance of DependencyContainer which then are injected to PhpOrmLite threw
 * it's constructor hence allowing all internal parts of PhpOrmLite access to
 * the different dependencies like the PDO-instance.
 */
$dc = new DependencyContainer();
$dc->setPdo($pdo);


/**
 * Make sure you have edited the configuration file conf.json in your
 * root folder and set your database options.
 *
 * Create an instance of PhpOrmLite.
 */
$orm = new PhpOrmLite($dc);

/**
 * To write actual model class files for each table in your database,
 * call the writeModels() function with the optional bool parameter
 * $overWrite to indicate whether or not to overwrite existing
 * model file.
 * $overWrite is false by default
 */
$orm->writeModels(true);

/**
 * Call getTables() to get an array of Table objects representing
 * the tables in your database.
 */
$tables = $orm->getTables();

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
try {
    foreach (Products::getAll() as $product) {
        echo "{$product->getSku()}: {$product->getTitle()}<br>";
    }
} catch (Exception $exception) {
    echo $exception->getMessage();
}