@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="list-inline">Database Schema : <strong>@{{ dbName }}</strong></span>

                        <button class="btn hidden-print" onclick="window.print()">Print</button>

                        <button class="btn hidden-print" v-if="!showForeignKey" @click="showForeignKey = true">Show Foreign Key</button>
                        <button class="btn hidden-print" v-if="showForeignKey" @click="showForeignKey = false">Hide Foreign Key</button>
                    </div>
                    <div class="panel-body">
                        <schema-view v-bind:db-schema="dbSchema" v-bind:show-foreign-key="showForeignKey"></schema-view>
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
                showForeignKey: true,
                dbName: "{{ $dbSchema->getName() }}",
                dbSchema: {!! json_encode($dbSchema->toArray()) !!}
            }
        });

    </script>
@endsection