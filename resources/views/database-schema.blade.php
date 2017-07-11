@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="list-inline">Database Schema : <strong>{{ $dbSchema->getName() }}</strong></span>

                        <button class="btn hidden-print" onclick="window.print()">Print</button>
                    </div>
                    <div class="panel-body">
                        @foreach($dbSchema->getTables() as $table)
                            <table class="table table-bordered table-list">
                                <caption>{{ $table->name }}</caption>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Allow Null</th>
                                        <th>Key/Attributes</th>
                                        <th>Default</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($table->columns->toArray() as $column)
                                        <tr>
                                            <td>{{ $column->name }}</td>
                                            <td>{{ $column->type }}</td>
                                            <td>{{ $column->notnull ? '' : 'Nullable' }}</td>
                                            <td>{{ $column->isPrimaryKey ? 'PK' : '' }}{{ $column->isForeignKey ? ' FK' : '' }}</td>
                                            <td>{{ $column->default }} {{ $column->autoincrement ? 'Auto Increment' : '' }}</td>
                                        </tr>
                                    @endforeach
                                    @if($table->foreignKeys)
                                        <tr>
                                            <td colspan="5">
                                                <table width="100%" class="table table-bordered foreign-keys">
                                                    <caption>Foreign Keys</caption>
                                                        <thead>
                                                            <tr>
                                                                <th>Constraint Name</th>
                                                                <th>Local Table</th>
                                                                <th>Local Column</th>
                                                                <th>Foreign Table</th>
                                                                <th>Foreign Column</th>
                                                            </tr>
                                                        </thead>
                                                    <tbody>
                                                        @foreach($table->foreignKeys as $foreignKey)
                                                            <tr>
                                                                <td>{{ $foreignKey->getName() }}</td>
                                                                <td>{{ $foreignKey->getLocalTableName() }}</td>
                                                                <td>{{ implode(',', $foreignKey->getLocalColumns()) }}</td>
                                                                <td>{{ $foreignKey->getForeignTableName() }}</td>
                                                                <td>{{ implode(',', $foreignKey->getForeignColumns()) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection