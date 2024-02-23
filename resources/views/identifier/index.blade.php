@extends('layouts.master')

@push('styles')
<link href="{{ asset('js/DataTables/datatables.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<div class="page-heading row">
        <div class="col-md-6">  <h1 class="page-title">Product Indentifier</h1></div>
        {{-- <div class="col-md-6"><a class="btn btn-info float-right mt-4" href="{{ route('products.create') }}" > <i class="fa fa-plus"></i> Create</a></div> --}}
</div>

<div class="page-content pt-2 fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Filter</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        <a class="fullscreen-link"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                <form action="{{ route('product-identifiers.index') }}">
                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label>Start Date : </label>
                            <div class="input-group date">
                                <span class="input-group-addon bg-white"><i class="fa fa-calendar"></i></span>
                                <input class="form-control date-picker-default" type="text" name="start_date" placeholder="Start Date" value="{{ request('start_date') }}">
                            </div>
                        </div>
                        <div class="col-sm-4 form-group">
                            <label>End Date : </label>
                            <div class="input-group date">
                                <span class="input-group-addon bg-white"><i class="fa fa-calendar"></i></span>
                                <input class="form-control date-picker-default" type="text" name="end_date" placeholder="End Date" value="{{ request('end_date') }}">
                            </div>
                        </div>
                        <div class="col-sm-4 form-group d-none">
                            <label>Customer Name : </label>
                            <input class="form-control" type="text" name="customer_id" placeholder="Customer Name" value="{{ request('customer_id') }}">
                        </div>
                        <div class="col-sm-4 form-group" >
                            <label>Status: </label>
                            <select name="indentifier_status_id" class="form-control" id="">
                                <option value="">All</option>
                                <option value="1" {{ (request('indentifier_status_id') == 1) ? 'selected' : '' }}  >Not Yet Assign</option>
                                <option value="2" {{ (request('indentifier_status_id') == 2) ? 'selected' : '' }}  >Float</option>
                                <option value="3" {{ (request('indentifier_status_id') == 3) ? 'selected' : '' }}  >Installed</option>
                            </select>
                        </div>
                    <div class="form-group col-sm-6 text-left">
                        <button class="btn btn-info" type="submit" name="download">Download</button>
                    </div>
                    <div class="form-group col-sm-6 text-right">
                            <a class="btn btn-outline-default" href="{{ route('product-identifiers.index') }}" type="submit">Refresh</a>
                            <button class="btn btn-danger" type="submit">Search</button>
                    </div>
                    </div>
                </form>
                </div>
            </div>
        </div>

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
                                    <th>Date & Time</th>
                                    <th>Batch</th>
                                    <th>Product</th>
                                    <th>Warehouse</th>
                                    <th>BST ID</th>
                                    <th>Identifier</th>
                                    <th class="text-center">User</th>
                                    <th class="text-center">Deliverd Time</th>
                                    <th class="text-center">Customer</th>
                                    <th class="text-center">Provider</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($ProductIdentifiers)
                                    @foreach ($ProductIdentifiers as $key => $ProductIdentifier)
                                        <tr>
                                            <td>{{  $key + 1 }}</td>
                                            <td >{{ $ProductIdentifier->created_at  }}</td>
                                            <td >{{ $ProductIdentifier->batch->code  }}</td>
                                            <td >{{ $ProductIdentifier->product->name  }}</td>
                                            <td >{{ $ProductIdentifier->product->location  }}</td>
                                            <td >{{ $ProductIdentifier->secondary_code  }}</td>
                                            <td >{{ $ProductIdentifier->code  }}</td>
                                            <td  class="text-center">{{ $ProductIdentifier->user->name  }}</td>
                                            <td  class="text-center">{{ $ProductIdentifier->float_user_add_at }}</td>
                                            <td class="text-center">{{ $ProductIdentifier->customer->name  }}</td>
                                            <td class="text-center">{{ $ProductIdentifier->customer->provider->name  }}</td>
                                            <td class="text-center">
                                                @if ($ProductIdentifier->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Deactive</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (false)
                                                 {{-- @if (auth()->user()->is_super_admin)  --}}
                                                    <a href="{{ route('products.edit', $ProductIdentifier->id)}}" class="btn btn-default btn-xs m-r-5" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil font-14"></i></a>
                                                    <form action="{{ route('products.destroy',$ProductIdentifier->id) }}" method="post" class="d-inline-block">
                                                        <button class="btn btn-default btn-xs" data-toggle="tooltip" type="submit" data-original-title="Delete"><i class="fa fa-trash font-14"></i></button>
                                                        <input type="hidden" name="_method" value="delete" />
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    </form>
                                                @else
                                                    -
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @if(!Request::has('user_id') && !Request::has('product_id')){
        <script type="text/javascript">
            $(function() {
                $('#item-table').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url"   : '{{ route('product-identifiers.datatable')}}',
                        "type"  : 'POST',
                        "data"  : {
                            start_date : '{{ request('start_date') }}',
                            end_date : '{{ request('end_date') }}',
                            customer_id : '{{ request('customer_id') }}',
                            indentifier_status_id : '{{ request('indentifier_status_id') }}',
                        }
                    },
                    "columnDefs": [
                        {"className": "text-center", "targets": "_all"}
                    ],
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'created_at', name: 'created_at' , searchable : false },
                        { data: 'batch.code', name: 'batch.code' },
                        { data: 'product.name', name: 'product.name' },
                        { data: 'location.name', name: 'location.name' },
                        { data: 'secondary_code', name: 'secondary_code' },
                        { data: 'code', name: 'code' },
                        { data: 'user.name', name: 'user.name' },
                        { data: 'float_user_add_at', name: 'float_user_add_at', searchable : false  },
                        { data: 'customer.name', name: 'customer.name' },
                        { data: 'customer.provider.name', name: 'customer.provider.name' },
                        { data: 'status', name: 'status', searchable : false },
                        { data: 'action', name: 'action', searchable : false }
                    ]
                });
            })
        </script>
    @else
        <script type="text/javascript">
            $(function() {
                $('#item-table').DataTable({
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
    @endif


@endpush
