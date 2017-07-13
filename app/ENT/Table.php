<?php

namespace App\ENT;

use DB;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;

/**
 * Class Table
 *
 * @package App\ENT
 */
class Table
{
    /**
     * Table Name
     *
     * @var string
     */
    protected $name;

    /**
     * List of columns
     *
     * @var array
     */
    protected $columns = null;

    /**
     * List of columns
     *
     * @var array|null
     */
    protected $foreignKeys = null;

    /**
     * List of columns
     *
     * @var array|null
     */
    protected $primaryKeys = null;

    /**
     * Table constructor
     *
     * @param string $tableName
     */
    public function __construct($tableName)
    {
        $this->name = $tableName;

        $this->setAttributes();
    }

    public function __get($name)
    {
        return $this->{$name};
    }

    /**
     * Fetch & fill all table & columns attribute
     */
    protected function setAttributes()
    {
        $tableDetail = $this->getDoctrineSchemaManager()->listTableDetails($this->name);

        $this->foreignKeys = $tableDetail->getForeignKeys();
        $this->primaryKeys = $tableDetail->hasPrimaryKey() ?
            $tableDetail->getPrimaryKeyColumns() : null;
        $this->fillColumns($tableDetail->getColumns());
    }

    /**
     * Fill Columns data
     *
     * @param string|null $columns
     * @return array
     */
    protected function fillColumns($columns = null)
    {
        if( ! $columns) {
            $this->getDoctrineSchemaManager()->listTableColumns($this->name);
        }

        $this->columns = collect(array_map(function($column) {
            return new Column($column->toArray());
        }, array_values($columns)));

        $this->foreignKeysInColumns();

        $this->primaryKeysInColumns();
    }

    /**
     * Set foreignKeys In related Columns.
     */
    protected function foreignKeysInColumns()
    {
        if($this->foreignKeys) {
            foreach ($this->foreignKeys as $foreignKey) {
                $this->columns->whereIn('name', $foreignKey->getLocalColumns())->each(function($value) use($foreignKey) {
                    $value->setForeignKey($foreignKey);
                });
            }
        }
    }

    /**
     * Set primaryKeys In related Columns.
     */
    protected function primaryKeysInColumns()
    {
        if($this->primaryKeys) {
            foreach ($this->primaryKeys as $primaryKey) {
                $this->columns->whereIn('name', $primaryKey)->each(function($value) {
                    $value->isPrimaryKey = true;
                });
            }
        }
    }

    /**
     * Get Default Doctrine Schema Manager
     *
     * @return AbstractSchemaManager
     */
    protected function getDoctrineSchemaManager()
    {
        return DB::getDoctrineSchemaManager();
    }

    /**
     * Get attributes in array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'foreignKeys' => $this->foreignKeys ? array_map(function ($key) {
                return $this->foreignKeyToArray($key);
            }, $this->foreignKeys) : null,
            'columns' => array_map(function ($column) {
                return $column->toArray();
            }, $this->columns->toArray())
        ];
    }

    /**
     * @param ForeignKeyConstraint $foreignKey
     * @return array
     */
    protected function foreignKeyToArray($foreignKey)
    {
        return [
            'constraint_name' => $foreignKey->getName(),
            'local_table' => $foreignKey->getLocalTableName(),
            'local_columns' => $foreignKey->getLocalColumns(),
            'foreign_table' => $foreignKey->getForeignTableName(),
            'foreign_columns' => $foreignKey->getForeignColumns()
        ];
    }
}