@extends('layouts.master')

@push('styles')

@endpush

@section('content')

<div class="page-heading row">
        <div class="col-md-6">  <h1 class="page-title">User Wise Product Status</h1></div>
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>User Name</th>
                                    <th class="text-center">Total Received</th>
                                    <th class="text-center">Total Floating</th>
                                    <th class="text-center">Total Installed</th>
                                    {{-- <th class="text-center">Last Update</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($UserProductProductStatus as $key =>  $UserProduct)
                                <tr>
                                    <td>{{  $key + 1 }}</td>
                                    <td >{{ $UserProduct->product_name  }}</td>
                                    <td >{{ $UserProduct->user_name  }}</td>
                                    <td class="text-center" >
                                        @if ($UserProduct->has_identifier)
                                            <a href="{{ route('product-identifiers.index', [ 'user_id' => $UserProduct->user_id, 'product_id' => $UserProduct->product_id ]) }}">{{ $UserProduct->TerminalReceivedCount }} {{ $UserProduct->unit_name }}</a>
                                        @else
                                            {{ $UserProduct->TerminalReceivedCount }} {{ $UserProduct->unit_name }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($UserProduct->has_identifier)
                                        <a href="{{ route('product-identifiers.index', [ 'user_id' => $UserProduct->user_id, 'product_id' => $UserProduct->product_id, 'is_floating' => 1 ]) }}"> {{  $UserProduct->TerminalReceivedCount - $UserProduct->TerminalInstalledCount  }} {{ $UserProduct->unit_name }} </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($UserProduct->has_identifier)
                                            {{ $UserProduct->TerminalInstalledCount  }} {{ $UserProduct->unit_name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    {{-- <td class="text-center">{{ $UserProduct->created_time  }}</td> --}}
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
@endpush
