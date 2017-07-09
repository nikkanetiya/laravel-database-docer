<?php

namespace App\ENT;

use App\ENT\Table;
use DB;
use Config;

/**
 * Class Database
 * @package App\Database
 */
class Database
{
    /**
     * Database Name
     *
     * @var string
     */
    protected $name;

    /**
     * List of tables
     *
     * @var array
     */
    protected $tables;

    /**
     * Database constructor.
     * @param string|null $dbName
     */
    public function __construct($dbName = null)
    {
        $dbName = $dbName?: DB::getDatabaseName();

        $this->setName($dbName);
    }

    /**
     * Change mysql connection and connect to other database
     *
     * @param string $dbName
     */
    protected function connectToDatabase($dbName)
    {
        $defaultConfig = Config::get($this->getDBConfigKey());

        // Set our targeted database name
        $defaultConfig['database'] = $dbName;

        // Our new config
        Config::set($this->getDBConfigKey('docer'), $defaultConfig);

        // Set our newly created config as default connection
        DB::setDefaultConnection('docer');
        $this->registerEnums();
    }

    /**
     * Get database connection config key
     * @param null $connectName
     * @return string
     */
    protected function getDBConfigKey($connectName = null)
    {
        if(!$connectName) $connectName = DB::getDefaultConnection();

        return 'database.connections.' . $connectName;
    }

    /**
     * Register enum types as string.
     */
    protected function registerEnums()
    {
        $platform = $this->getDoctrineSchemaManager()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');
        $platform->registerDoctrineTypeMapping('json', 'text');
    }

    /**
     * Get Database Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set/Change Database name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        $this->fillTablesData();
    }

    /**
     * Get Tables data.
     *
     * @return array
     */
    public function getTablesData()
    {
        if(!$this->tables) $this->fillTablesData();

        return $this->tables;
    }

    /**
     * Fill table ENT
     */
    protected function fillTablesData()
    {
        $this->connectToDatabase($this->name);

        $this->tables = collect(array_map(function ($result) {
            return new Table($result);
        }, $this->fetchTableNames()));
    }

    /**
     * Get Tables name list
     *
     * @return array
     */
    protected function fetchTableNames()
    {
        return $this->getDoctrineSchemaManager()->listTableNames();
    }

    /**
     * Get Default Doctrine Schema Manager
     *
     * @return \Doctrine\DBAL\Schema\AbstractSchemaManager
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
        $obj = get_object_vars($this);
        $obj['tables'] = array_map(function($table) {
            return $table->toArray();
        }, $this->tables->toArray());

        return $obj;
    }
}