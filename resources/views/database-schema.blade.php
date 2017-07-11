@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div>
                            <span>Database Schema : <strong>@{{ dbName }}</strong></span>

                            <label class="radio-inline hidden-print">
                                <input type="radio" value="1" v-model="dataOption" checked>All
                            </label>
                            <label class="radio-inline hidden-print">
                                <input type="radio" value="2" v-model="dataOption">Without Foreign Key
                            </label>
                            <label class="radio-inline hidden-print">
                                <input type="radio" value="3" v-model="dataOption">Only Foreign Key
                            </label>

                            <button class="btn hidden-print" onclick="window.print()">Print</button>
                        </div>
                    </div>

                    <div class="panel-body">
                        <schema-view v-bind:db-tables="dbSchema.tables" v-bind:data-option="dataOption"></schema-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const app = new Vue({
            el: '#app',
            data: {
                dataOption: 1,
                dbName: "{{ $dbSchema->getName() }}",
                dbSchema: {!! json_encode($dbSchema->toArray()) !!}
            }
        });

    </script>
@endsection