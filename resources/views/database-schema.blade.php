@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="list-inline">Database Schema : <strong>{{ $dbName }}</strong></span>

                        <button class="btn hidden-print" onclick="window.print()">Print</button>
                    </div>
                    <div class="panel-body">
                        @foreach($tables as $table)
                            <table class="table table-bordered table-list">
                                <caption>{{ $table->getName() }}</caption>
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
                                    <?php $primaryKeys = $table->getPrimaryKey();
                                          $primaryKeys = $primaryKeys ? $primaryKeys->getColumns() :[]
                                    ?>
                                    @foreach($table->getColumns() as $column)
                                        <tr>
                                            <td>{{ $column->getName() }}</td>
                                            <td>{{ $column->getType()->getName() . ($column->getLength() ? "({$column->getLength()})" :'') }}</td>
                                            <td>{{ $column->getNotnull() ? null : 'Nullable' }}</td>
                                            <td>{{ $primaryKeys && in_array($column->getName(), $primaryKeys) ? 'Primary' : '' }}</td>
                                            <td>{{ $column->getDefault() }}</td>
                                        </tr>
                                    @endforeach
                                    <?php $foreignKeys = $table->getForeignKeys();
                                    ?>
                                    @if($foreignKeys)
                                        <tr>
                                            <td colspan="5">
                                                <table width="100%" class="table table-bordered foreign-keys">
                                                    <caption>Foreign Keys</caption>
                                                    <thead>
                                                        <th>Constraint Name</th>
                                                        <th>Local Table</th>
                                                        <th>Local Column</th>
                                                        <th>Foreign Table</th>
                                                        <th>Foreign Column</th>
                                                    </thead>
                                                    @foreach($foreignKeys as $foreignKey)
                                                        <tr>
                                                            <td>{{ $foreignKey->getName() }}</td>
                                                            <td>{{ $foreignKey->getLocalTableName() }}</td>
                                                            <td>{{ implode(',', $foreignKey->getLocalColumns()) }}</td>
                                                            <td>{{ $foreignKey->getForeignTableName() }}</td>
                                                            <td>{{ implode(',', $foreignKey->getForeignColumns()) }}</td>
                                                        </tr>
                                                    @endforeach
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