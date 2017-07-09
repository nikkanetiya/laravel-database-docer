<?php

namespace App\ENT;

/**
 * Class Column
 * @package App\Database
 */
class Column
{
    /**
     * Tale
     *
     * @var Table
     */
    public $table;

    /**
     * Column Name
     *
     * @var string
     */
    public $name;

    /**
     * Column type
     *
     * @var \Doctrine\DBAL\Types\Type
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
     * .
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
     * @param $value
     */
    public function setForeignKey(\Doctrine\DBAL\Schema\ForeignKeyConstraint $value)
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

        return $obj;
    }
}