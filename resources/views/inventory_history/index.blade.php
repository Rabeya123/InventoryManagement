@extends('layouts.master')

@push('styles')
    <link href="{{ asset('js/DataTables/datatables.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<div class="page-heading row">
        <div class="col-md-6">  <h1 class="page-title">Inventory History</h1></div>
        <div class="col-md-6"><a class="btn btn-info float-right mt-4" href="{{ route('inventories.create', ['type_id' => 1]) }}" > <i class="fa fa-plus"></i> Create</a></div>
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
                        <table class="table table-striped table-bordered table-hover" id="item-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Product Name</th>
                                    <th>Location</th>
                                    <th class="text-center">Source</th>
                                    <th class="text-center">IN/OUT</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Created By</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (Request::has('product_id'))
                                    @foreach ($ProductHistories as $ProductHistory)
                                        <tr>
                                            <td>{{ $ProductHistory->id }}</td>
                                            <td >{{ $ProductHistory->date  }}</td>
                                            <td >{{ $ProductHistory->product->name  }}</td>
                                            <td >{{ $ProductHistory->location->name  }}</td>
                                            <td >{{ $ProductHistory->ref_type  }}</td>

                                            <td class="text-center">
                                                @if ($ProductHistory->type == "IN")
                                                    <span class="badge badge-success">IN</span>
                                                @else
                                                    <span class="badge badge-danger">OUT</span>
                                                @endif
                                            </td>

                                            <td class="text-center">{{ $ProductHistory->quantity }} {{ $ProductHistory->product->unit->name }}</td>

                                            <td class="text-center">
                                                @if ($ProductHistory->is_active)
                                                    <span class="badge badge-success">Approved</span>
                                                @else
                                                    <span class="badge badge-danger">Pending</span>
                                                @endif
                                            </td>

                                            <td class="text-center">{{ $ProductHistory->created_user->name  }}</td>

                                            <td class="text-center">
                                                @if (!$ProductHistory->is_active)
                                                    <a href="{{ route('companies.edit', $ProductHistory->id)}}" class="btn btn-default btn-xs m-r-5" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil font-14"></i></a>
                                                    <form action="{{ route('companies.destroy', $ProductHistory) }}" method="post" class="d-inline-block">
                                                        <button class="btn btn-default btn-xs" data-toggle="tooltip" type="submit" data-original-title="Delete"><i class="fa fa-trash font-14"></i></button>
                                                        <input type="hidden" name="_method" value="delete" />
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    </form>
                                                @else
                                                    Not Applicable
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
@if (!Request::has('product_id'))
    <script src="{{asset('js\DataTables\datatables.min.js')}}" type="text/javascript"></script>
    <script>
        $('#item-table').DataTable({
            order : [[ 1, 'desc' ]],
            processing: true,
            serverSide: true,
            ajax: '{{ route('inventory-histories.index') }}',
            "columnDefs": [
                {"className": "text-center", "targets": "_all"}
            ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'date', name: 'date'},
                {data: 'product.name', name: 'product.name'},
                {data: 'location.name', name: 'location.name'},
                {data: 'ref_type', name: 'ref_type', searchable : false},
                {data: 'status', name: 'status', searchable : false},
                {data: 'quantity', name: 'quantity', searchable : false},
                {data: 'type', name: 'type'},
                {data: 'created_user.name', name: 'created_user.name'},
                {data: 'action', name: 'action', searchable : false},
            ]
        });
    </script>
@endif
@endpush
