<?php

namespace App\Http\Controllers;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDatabaseSchemaView()
    {
        // Current no database selection, just get schema for default connection
        $tables = \DB::getDoctrineSchemaManager()->listTables();

        return view('database-schema', compact('tables'));
    }
}
