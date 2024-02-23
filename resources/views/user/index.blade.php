@extends('layouts.master')

@push('styles')
<link href="js/DataTables/datatables.min.css" rel="stylesheet" />
@endpush

@section('content')

<div class="page-heading row">
    <div class="col-md-6">  <h1 class="page-title">User</h1></div>
    <div class="col-md-6"><a class="btn btn-info float-right mt-4" href="{{ route('users.create') }}" > <i class="fa fa-plus"></i> Create</a></div>
</div>

<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">

            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Create</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        <a class="fullscreen-link"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <div class="ibox-body">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="user_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Users as $User)
                                <tr>
                                    <td>{{ $User->id }}</td>
                                    <td >{{ $User->name  }}</td>
                                    <td >{{ $User->email  }}</td>
                                    <td >{{ $User->mobile  }}</td>
                                    <td class="text-center" >{{ ($User->role_id == 1 || $User->role_id == 2) ? "Admin" : "Staff"}}</td>
                                    <td class="text-center">
                                        @if ($User->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Deactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                    <a href="{{ route('users.edit', $User->id)}}" class="btn btn-default btn-xs m-r-5" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil font-14"></i></a>
                                    <form action="{{ route('users.destroy', $User->id) }}" method="post" class="d-inline-block">
                                        <button class="btn btn-default btn-xs" data-toggle="tooltip" type="submit" data-original-title="Delete"><i class="fa fa-trash font-14"></i></button>
                                        <input type="hidden" name="_method" value="delete" />
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </form>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>



        </div>
    </div>
</div>

@stop

@push('scripts')
<script src="{{asset('js\DataTables\datatables.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#user_table').DataTable({
            pageLength: 10,
            //"ajax": './assets/demo/data/table_data.json',
            /*"columns": [
                { "data": "name" },
                { "data": "office" },
                { "data": "extn" },
                { "data": "start_date" },
                { "data": "salary" }
            ]*/
        });
    })
</script>
@endpush
