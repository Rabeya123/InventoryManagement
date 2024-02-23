@extends('layouts.master')

@push('styles')
<link href="{{ asset('js/DataTables/datatables.min.css') }}" rel="stylesheet" />

@endpush

@section('content')

<div class="page-heading row">
        <div class="col-md-6">  <h1 class="page-title">Requisition</h1></div>
        <div class="col-md-6"><a class="btn btn-info float-right mt-4" href="{{ route('requisitions.create') }}" > <i class="fa fa-plus"></i> Create</a></div>
</div>

<div class="page-content pt-2 fade-in-up">
    <div class="row">
        <div class="col-md-12">

            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">List</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        <a class="fullscreen-link"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="requisition">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Code</th>
                                    <th>Requisition for</th>
                                    <th>Requisition By</th>
                                    <th>Approved By</th>
                                    <th class="text-center">Total Quantity</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Requisitions as $Requisition)
                                <tr>
                                    <td>{{ $Requisition->id }}</td>
                                    <td >{{ $Requisition->date  }}</td>
                                    <td >{{ $Requisition->code  }}</td>
                                    <td >{{ $Requisition->requisition_for->name  }}</td>
                                    <td >{{ $Requisition->requisition_by->name  }}</td>
                                    <td >{{ $Requisition->requisition_by->name  }}</td>
                                    <td class="text-center">{{ $Requisition->products_sum_quantity  }} Unit</td>
                                    <td class="text-center">
                                        @switch($Requisition->status)
                                            @case('pending')
                                                <span class="badge badge-warning">{{ ucfirst($Requisition->status) }}</span>
                                                @break
                                            @case('approved')
                                                <span class="badge badge-success">{{ ucfirst('Delivered') }}</span>
                                                @break
                                            @default
                                                <span class="badge badge-danger">{{ ucfirst($Requisition->status) }}</span>
                                        @endswitch
                                    </td>
                                    </td>
                                    <td class="text-center">
                                        @if ($Requisition->status == 'approved')
                                            <a href="{{ route('requisitions.show', $Requisition->id)}}/?is_print=1" class="btn btn-default btn-xs m-r-5" target="_blank" data-toggle="tooltip" data-original-title="Show"><i class="fa fa-print font-14"></i></a>
                                        @endif
                                        <a href="{{ route('requisitions.show', $Requisition->id)}}" class="btn btn-default btn-xs m-r-5" data-toggle="tooltip" data-original-title="Show"><i class="fa fa-eye font-14"></i></a>
                                        @if ($Requisition->status == 'pending')
                                            <a href="{{ route('requisitions.edit', $Requisition->id)}}" class="btn btn-default btn-xs m-r-5" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil font-14"></i></a>
                                            <form action="{{ route('requisitions.destroy', $Requisition) }}" method="post" class="d-inline-block">
                                                <button class="btn btn-default btn-xs" data-toggle="tooltip" type="submit" data-original-title="Delete"><i class="fa fa-trash font-14"></i></button>
                                                <input type="hidden" name="_method" value="delete" />
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            </form>
                                        @endif
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
<script src="{{ asset('js\DataTables\datatables.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#requisition').DataTable({
            order: [[ 0, 'desc' ]],
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
