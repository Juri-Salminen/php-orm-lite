<?php
$class = "<?php


namespace Gutenisse\PhpOrmLite\Models;

use Exception;
use Gutenisse\PhpOrmLite\Model;

class {$this->getUcaseFirst($this->getName())}
{\n";
$class .= "\tprivate static string \$_tableName = \"{$this->getName()}\";\n";

foreach ($this->getColumns() as $column) {
    if($column->getName() !== "id") {
        $defaultValue = $this->getType($column) === "string" ? " = \"\"" : " = 0";
    } else {
        $defaultValue = "";
    }
    $class .= "\tpublic {$this->getType($column)} \${$this->getLowercase($column->getName())}{$defaultValue};\n";
}

$class .= "
    /**
    * @throws Exception
    */
    public function save() : void
    {
        Model::save(\$this, self::\$_tableName);
    }\n";

$class .= "
    /**
    * @return {$this->getUcaseFirst($this->getName())}[]
    * @throws Exception
    */
    public static function getAll() : array
    {
        try {
            \$products = Model::list(self::\$_tableName);
        } catch (Exception \$exception) {
            throw \$exception;
        }
        
        return \$products;
    }\n";

$class .= "
    /**
    * @param  int \$id
    *
    * @return {$this->getUcaseFirst($this->getName())}
    * @throws Exception
    */
    public static function getById(int \$id) : {$this->getUcaseFirst($this->getName())}
    {
        try {
            return Model::get(\$id, self::\$_tableName);
        } catch (Exception \$exception) {
            throw \$exception;
        }
    }
";

$class .= "\n";

//foreach ($this->getColumns() as $column) {
//    $type = $column->isNumeric() ? "int" : "string";
//    $class .= "\tpublic function get{$this->getUcaseFirst($column->getName())}() : {$type}\n";
//    $class .= "\t{\n";
//    $class .= "\t\treturn \$this->{$this->getLowercase($column->getName())};\n";
//    $class .= "\t}\n\n";
//
//    $class .= "\tpublic function set{$this->getUcaseFirst($column->getName())}($type \$value) : void\n";
//    $class .= "\t{\n";
//    $class .= "\t\t\$this->{$this->getLowercase($column->getName())} = \$value;\n";
//    $class .= "\t}\n\n";
//}

$class .= "}";