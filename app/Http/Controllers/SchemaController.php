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
        $this->currentDb = DB::getDoctrineConnection()->getDatabase();
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

        // connect to selected database
        // Remaining fixing name from slug
        $this->connectToDatabase($dbName);

        // Current no database selection, just get schema for default connection
        $tables = $this->getTables();

        return view('database-schema', compact('tables', 'dbName'));
    }

    /**
     * Return the list of tables details for the database connection.
     *
     * @return \Doctrine\DBAL\Schema\Table[]
     */
    protected function getTables()
    {
        return DB::getDoctrineSchemaManager()->listTables();
    }

    /**
     * Change mysql connection and connect to other database
     *
     * @param string $dbName
     */
    protected function connectToDatabase($dbName)
    {
        Config::set('database.connections.mysql.database', $dbName);
        DB::reconnect();
        $this->registerEnums();
    }

    /**
     * Register enum types as string.
     */
    protected function registerEnums()
    {
        $platform = DB::getDoctrineConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');
    }
}
