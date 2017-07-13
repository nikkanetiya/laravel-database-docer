<?php

namespace App\ENT;

use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Types\Type;

/**
 * Class Column
 * @package App\ENT
 */
class Column
{
    /**
     * Column Name
     *
     * @var string
     */
    public $name;

    /**
     * Column type
     *
     * @var Type
     */
    public $type;

    /**
     * Default values
     *
     * @var mixed
     */
    public $default;

    /**
     * Is not null
     *
     * @var boolean
     */
    public $notnull;

    /**
     * Column type
     *
     * @var integer|null
     */
    public $length;

    /**
     * Column Precision
     *
     * @var integer|null
     */
    public $precision;

    /**
     * Column Scale
     *
     * @var integer|null
     */
    public $scale;

    /**
     * Is column fixed
     *
     * @var boolean
     */
    public $fixed;

    /**
     * Is column unsigned
     *
     * @var boolean
     */
    public $unsigned;

    /**
     * Is column autoincrement
     *
     * @var boolean
     */
    public $autoincrement;

    /**
     * column definition
     *
     * @var string|null
     */
    public $columnDefinition;

    /**
     * column comment
     *
     * @var string|null
     */
    public $comment;

    /**
     * Is Column is primary key
     *
     * @var boolean
     */
    public $isPrimaryKey = false;

    /**
     * Is Column is primary key
     *
     * @var boolean
     */
    public $isForeignKey = false;

    /**
     * ForeignKeyConstraint
     *
     * @var ForeignKeyConstraint|null
     */
    public $foreignKey = null;

    /**
     * Column constructor
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        foreach ($attributes as $key => $attribute) {
            $this->{$key} = $attribute;
        };
    }

    /**
     * Set ForeignKey for the column
     *
     * @param ForeignKeyConstraint $value
     */
    public function setForeignKey(ForeignKeyConstraint $value)
    {
        $this->foreignKey = $value;
        $this->isForeignKey = true;
    }

    /**
     * Get attributes in array
     *
     * @return array
     */
    public function toArray()
    {
        $obj = get_object_vars($this);
        $obj['type'] = $obj['type']->getName();
        $obj['foreignKey'] = $this->foreignKeyToArray();

        return $obj;
    }

    /**
     * @return array|null
     */
    protected function foreignKeyToArray()
    {
        if( ! $this->foreignKey) {
            return null;
        }

        return [
            'constraint_name' => $this->foreignKey->getName(),
            'local_table' => $this->foreignKey->getLocalTableName(),
            'local_columns' => $this->foreignKey->getLocalColumns(),
            'foreign_table' => $this->foreignKey->getForeignTableName(),
            'foreign_columns' => $this->foreignKey->getForeignColumns()
        ];
    }
}