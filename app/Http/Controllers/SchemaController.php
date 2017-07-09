<?php

namespace App\Http\Controllers;

use DB;
use Config;

class SchemaController extends Controller
{
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

        return view('database', compact('databases'));
    }

    /**
     * Get View showing list of available database
     *
     * @param string $dbName
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDatabaseSchemaView($dbName)
    {
        // connect to selected database
        // Remaining fixing name from slug
        $this->connectToDatabase($dbName);

        // Current no database selection, just get schema for default connection
        $tables = $this->getTables();

        return view('database-schema', compact('tables', 'db'));
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
