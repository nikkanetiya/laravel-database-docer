@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="list-inline">Database Schema : <strong>@{{ name }}</strong></span>

                        <button class="btn hidden-print" onclick="window.print()">Print</button>
                    </div>
                    <div class="panel-body">
                        <table v-for="table in tables" v-if="tables" class="table table-bordered table-list">
                            <caption>@{{ table.name }}</caption>
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
                                <tr v-for="column in table.columns" v-if="table.columns">
                                    <td>@{{ column.name }}</td>
                                    <td>@{{ column.type }}</td>
                                    <td>@{{ column.notnull ? '' : 'Nullable' }}</td>
                                    <td>@{{ column.isPrimaryKey ? 'PK' : '' }} @{{ column.isForeignKey ? ' FK' : '' }}</td>
                                    <td>@{{ column.autoincrement ? 'Auto Increment' : '' }}</td>
                                </tr>
                                <tr v-if="table.foreignKeys">
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
                                                <tr v-for="foreignKey in table.foreignKeys">
                                                    <td>@{{ foreignKey.constraint_name }}</td>
                                                    <td>@{{ foreignKey.local_table }}</td>
                                                    <td>@{{ foreignKey.local_columns | implode }}</td>
                                                    <td>@{{ foreignKey.foreign_table }}</td>
                                                    <td>@{{ foreignKey.foreign_columns | implode }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        Vue.filter('implode', function (value, piece, key) {
            piece = piece ? piece : ', ';

            if(_.isUndefined(key)) {
                return value.join(piece);
            }

            return _.pluck(value, key).join(piece);
        });

        const app = new Vue({
            el: '#app',
            data: {!! json_encode($dbSchema->toArray()) !!}
        });
    </script>
@endsection