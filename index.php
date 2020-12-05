<?php


use Gutenisse\PhpOrmLite\PhpOrmLite;

require __DIR__."/vendor/autoload.php";

$orm = new PhpOrmLite();

// Create/write model class files to folder Models
$orm->writeModels();

// Get all tables
//$tables = $orm->getTables();
//foreach ($tables as $table) {
//    echo "{$table->getName()}<br>";
//}