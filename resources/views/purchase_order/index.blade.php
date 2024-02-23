@extends('layouts.master')

@push('styles')
    <link href="{{ asset('js/DataTables/datatables.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<div class="page-heading row">
        <div class="col-md-6">  <h1 class="page-title">Purchase Order</h1></div>
        <div class="col-md-6"><a class="btn btn-info float-right mt-4" href="{{ route('purchase-orders.create') }}" > <i class="fa fa-plus"></i> Create</a></div>
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
                                    <th>Title</th>
                                    <th>Code</th>
                                    <th>Supplier</th>
                                    <th>Created By</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Approved By</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($PurchaseOrders as $PurchaseOrder)
                                <tr>
                                    <td>{{ $PurchaseOrder->id }}</td>
                                    <td>{{ $PurchaseOrder->date  }}</td>
                                    <td>{{ $PurchaseOrder->title }}</td>
                                    <td >{{ $PurchaseOrder->code  }}</td>
                                    <td >{{ $PurchaseOrder->contact->name  }}</td>
                                    <td >{{ $PurchaseOrder->created_user->name  }}</td>
                                    <td class="text-center">{{ $PurchaseOrder->total  }}</td>
                                    <td class="text-center">
                                        @switch($PurchaseOrder->status)
                                            @case('pending')
                                                <span class="badge badge-warning">{{ ucfirst($PurchaseOrder->status) }}</span>
                                                @break
                                            @case('approved')
                                                <span class="badge badge-success">{{ ucfirst($PurchaseOrder->status) }}</span>
                                                @break
                                            @default
                                                <span class="badge badge-danger">{{ ucfirst($PurchaseOrder->status) }}</span>
                                        @endswitch
                                    </td>
                                    <td class="text-center">{{ $PurchaseOrder->approved_user->name  }}</td>
                                    <td class="text-center">
                                    @if ($PurchaseOrder->status == 'approved')
                                        <a href="{{ route('purchase-orders.show', $PurchaseOrder)}}?is_print=1" class="btn btn-default btn-xs m-r-5" data-toggle="tooltip" data-original-title="Print"><i class="fa fa-print font-14"></i></a>
                                    @endif
                                        <a href="{{ route('purchase-orders.edit', $PurchaseOrder)}}" class="btn btn-default btn-xs m-r-5" data-toggle="tooltip" data-original-title="@if ($PurchaseOrder->status == 'pending') Edit  @else Show @endif"><i class="fa @if ($PurchaseOrder->status == 'pending') fa-pencil  @else fa-eye @endif font-14"></i></a>
                                    @if ($PurchaseOrder->status == 'pending')
                                        <form action="{{ route('purchase-orders.destroy', $PurchaseOrder) }}" method="post" class="d-inline-block">
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
<script src="{{asset('js\DataTables\datatables.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#requisition').DataTable({
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
