<?php


use Gutenisse\PhpOrmLite\Config\Configuration;
use Gutenisse\PhpOrmLite\Factory;

require __DIR__."/vendor/autoload.php";

try {
    $config = new Configuration();
} catch (Exception $exception) {
    echo $exception->getMessage();
}

$options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ];

$con = new PDO(
    "mysql:host={$config->getDbConfig()->getHost()};dbname={$config->getDbConfig()->getDatabase()};port={$config->getDbConfig()->getPort()};charset=utf8mb4",
    $config->getDbConfig()->getUser(),
    $config->getDbConfig()->getPassword(),
    $options
);

$result = $con->query("SHOW TABLES;");

$factory = new Factory($con);
$tables = [];

foreach ($result->fetchAll(PDO::FETCH_BOTH) as $row) {
    $tables[] = $factory->createTable($row[0]);
    break;
}

foreach ($tables as $table) {
    echo "{$table->getName()}<br>";
    
    foreach ($table->getColumns() as $column) {
        echo "&nbsp;&nbsp;- {$column->getName()} {$column->getType()}({$column->getLength()})<br>";
    }
}