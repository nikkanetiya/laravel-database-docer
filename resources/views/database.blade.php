@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Database List</div>
                    <div class="panel-body">
                        @if($databases)
                            <select name="database" class="form-control" id="select-database">
                                <option value="">Select Database</option>
                                @foreach($databases as $database)
                                    <option {{ $currentDb == $database ? 'selected' : '' }} value="{{ url('database/schema', $database) }}">{{ $database }}</option>
                                @endforeach
                            </select>

                            <br>

                            <button class="btn btn-primary" id="btn-db-schema">Database Schema</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#btn-db-schema').click(function () {
                let selectedDb = $('#select-database').val();
                if  (selectedDb) {
                    window.location.href = selectedDb;
                }
            });
        });
    </script>
@endsection