# PHP ORM Lite
A simple PHP ORM for mapping database table rows to custom object types.

The repository is mainly for my own learning about PHP and Composer.

The example in example.php uses a MySql database with two tables:

`CREATE TABLE `products` (
`sku` VARCHAR(50) NULL DEFAULT NULL,
`title` VARCHAR(50) NULL DEFAULT NULL,
`created` VARCHAR(50) NULL DEFAULT NULL,
`changed` VARCHAR(50) NULL DEFAULT NULL,
`id` INT(11) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`id`) USING BTREE,
UNIQUE INDEX `sku` (`sku`) USING BTREE
)
ENGINE=InnoDB;`

CREATE TABLE `properties` (
`property` VARCHAR(50) NOT NULL DEFAULT '',
`id` INT(11) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`id`) USING BTREE,
UNIQUE INDEX `property` (`property`) USING BTREE
)
ENGINE=InnoDB;
