<?php

namespace App\Http\Controllers;

use DB;
use Config;

class SchemaController extends Controller
{
    /**
     * Default Connected DB
     * @var string $currentDb
     */
    protected $currentDb;

    /**
     * SchemaController constructor.
     * @param null $currentDb
     */
    public function __construct($currentDb = null)
    {
        $this->currentDb = DB::getDatabaseName();
    }

    /**
     * Get basic welcome view with having link for all actions.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getWelcomeView()
    {
        return view('welcome');
    }

    /**
     * Get View showing list of available database
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDatabaseListView()
    {
        $databases = \DB::getDoctrineSchemaManager()->listDatabases();

        return view('database', compact('databases'))
            ->with('currentDb', $this->currentDb);
    }

    /**
     * Get View showing list of available database
     *
     * @param string $dbName
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDatabaseSchemaView($dbName = null)
    {
        if(!$dbName) $dbName = $this->currentDb;

        // Remaining fixing name from slug
        $tables = $this->getTables($dbName);

        return view('database-schema', compact('tables', 'dbName'));
    }

    /**
     * Return the list of tables details for the database connection.
     *
     * @param $dbName
     * @return \Doctrine\DBAL\Schema\Table[]
     */
    protected function getTables($dbName)
    {
        if($this->currentDb != $dbName) {
            $this->connectToDatabase($dbName);
        }

        return DB::getDoctrineSchemaManager()->listTables();
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
        $platform = DB::getDoctrineSchemaManager()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');
        $platform->registerDoctrineTypeMapping('json', 'text');
    }
}
