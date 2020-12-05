<?php


namespace Gutenisse\PhpOrmLite\Db;


class Column
{
    private string $name;
    private string $type;
    private int $length;
    private int $decimals;
    private bool $nullable;
    private string $key;
    private ?string $default;
    private string $extra;
    private bool $numeric;
    
    /**
     * Column constructor.
     *
     * @param  array  $columns
     */
    public function __construct(array $columns) {
        foreach ($columns as $column => $value) {
            switch ($column) {
                case "Field": $this->name = $value; break;
                case "Type": $this->setColumnType($value); break;
                case "Key": $this->key = $value; break;
                case "Default": $this->default = $value; break;
                case "Extra": $this->extra = $value; break;
            }
        }
    }
    
    /**
     * Extract type information from the column "Type" returned from
     * the SQL "DESCRIBE TABLE_NAME;"
     * Most types prints like 'varchar(X)' where X is the lenght of the column.
     * Some types, like "longtext" does not have a lenght part and hence don't
     * have the value in "()".
     *
     * @param  string  $type
     */
    private function setColumnType(string $type)
    {
        // Find the "(" - if any.
        if(($left = strpos($type, "(")) !== false) {
            // Set the column type, i.e "varchar"
            $this->type = substr($type, 0, $left);
            
            // Find the ")"
            $right = strpos($type, ")", $left);
            
            // Get the length of the column
            $length = substr($type, $left + 1, $right - ($left + 1));
            
            // Get decimals, if any
            if(($decimal = strpos($length, ",")) !== false) {
                $lengths      = explode(",", $length);
                $this->length = $lengths[0];
                $this->decimals = $lengths[1];
            } else {
                $this->length = $length;
            }
            
            // Is the column type numeric?
            switch ($this->type) {
                case "tinyint":
                case "smallint":
                case "mediumint":
                case "int":
                case "bigint":
                case "bit":
                case "float":
                case "double":
                case "decimal":
                    $this->numeric = true;
                    break;
                default: $this->numeric = false;
            }
        } else {
            $this->type = $type;
        }
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * @return int
     */
    public function getLength() : int
    {
        return $this->length;
    }
    
    /**
     * @return bool
     */
    public function isNullable() : bool
    {
        return $this->nullable;
    }
    
    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }
    
    /**
     * @return string|null
     */
    public function getDefault()
    {
        return $this->default;
    }
    
    /**
     * @return string
     */
    public function getExtra()
    {
        return $this->extra;
    }
    
    /**
     * @return bool
     */
    public function isNumeric() : bool
    {
        return $this->numeric;
    }
    
    /**
     * @return int
     */
    public function getDecimals() : int
    {
        return $this->decimals;
    }
}