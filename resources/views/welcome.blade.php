@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Actions</div>
                    <div class="panel-body">
                        <div>
                            <a href="{{ url('database') }}">Database List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection