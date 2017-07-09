@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Database List</div>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $primaryKeys = $table->getPrimaryKey();
                                          $primaryKeys = $primaryKeys ? $primaryKeys->getColumns() :[]
                                    ?>
                                    @foreach($table->getColumns() as $column)
                                        <tr>
                                            <td>{{ $column->getName() }}</td>
                                            <td>{{ $column->getType()->getName() }}</td>
                                            <td>{{ $column->getNotnull() ? null : 'Nullable' }}</td>
                                            <td>{{ $primaryKeys && in_array($column->getName(), $primaryKeys) ? 'Primary' : '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection