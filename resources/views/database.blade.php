@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Database List</div>
                    <div class="panel-body">
                        <select name="database" class="form-control">
                            <option>Select Database</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection