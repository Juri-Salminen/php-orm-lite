<?php


use Gutenisse\PhpOrmLite\Config\Configuration;

try {
    $config = Configuration::create();
} catch (Exception $exception) {
    echo $exception->getMessage();
}
