<?php

namespace App\Http\Controllers;

use App\ENT\Database;

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

        return view('database', compact('databases'))
            ->with('currentDb', \DB::getDatabaseName());
    }

    /**
     * Get View showing list of available database
     *
     * @param string $dbName
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDatabaseSchemaView($dbName = null)
    {
        $dbSchema = new Database($dbName);

        return view('database-schema', compact('dbSchema'));
    }
}
