@extends('layouts.master')

@push('styles')
    <link href="js/DataTables/datatables.min.css" rel="stylesheet" />
@endpush

@section('content')

<div class="page-heading row">
        <div class="col-md-8">  <h1 class="page-title">Current Stock</h1></div>
        <div class="col-md-4 mt-4">
            <select class="form-control select_item_list float-right" id="location_id">
                    <option value="">Select Warehouse</option>
                @foreach ($Locations as $Location)
                    <option value="{{ $Location->id }}" {{ $Location->id == request('location_id') ? 'selected' : '' }} >
                        {{ $Location->name }}
                    </option>
                @endforeach
        </select>
        </div>
</div>

<div class="page-content pt-2 fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Warehouse Wise List</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        <a class="fullscreen-link"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="inventory">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Warehouse Name</th>
                                    <th>Product Name</th>
                                    <th>Code</th>
                                    <th class="text-center">Inhouse Stock</th>
                                    {{-- <th>Last Update</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($LocationProductStocks as $key => $ProductStock)

                                    @if (Request::has('location_id') && Request::get('location_id') == $ProductStock->LocationID)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td >
                                                <a href="{{ route('inventory-histories.index', [ 'product_id' => $ProductStock->product_id, 'location_id' => $ProductStock->LocationID  ]) }}">
                                                    {{ $ProductStock->LocationName }} {{ $ProductStock->LocationID }}
                                                </a>
                                            </td>
                                            <td >{{ $ProductStock->ProductName }}</td>
                                            <td >{{ $ProductStock->ProductCode }}</td>
                                            <td class="text-center">
                                                {{ $ProductStock->ProductIN -  $ProductStock->ProductOUT  }} {{ $ProductStock->UnitName }}
                                            </td>
                                            {{-- <td>{{ Carbon\Carbon::parse($ProductStock->LastUpdated)->format('d-m-Y h:i A') }}</td> --}}
                                        </tr>
                                    @endif

                                    @if (Request::has('location_id') && !Request::get('location_id') || !Request::has('location_id'))
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td >

                                                <a href="{{ route('inventory-histories.index', [ 'product_id' => $ProductStock->product_id, 'location_id' => $ProductStock->LocationID  ]) }}">
                                                    {{ $ProductStock->LocationName }}
                                                </a>
                                            </td>
                                            <td >{{ $ProductStock->ProductName }}</td>
                                            <td >{{ $ProductStock->ProductCode }}</td>
                                            <td class="text-center">
                                                {{ $ProductStock->ProductIN -  $ProductStock->ProductOUT  }} {{ $ProductStock->UnitName }}
                                            </td>
                                            {{-- <td>{{ Carbon\Carbon::parse($ProductStock->LastUpdated)->format('d-m-Y h:i A') }}</td> --}}
                                        </tr>
                                    @endif

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Product Wise List</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        <a class="fullscreen-link"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Code</th>
                                    <th class="text-center">Inhouse Stock</th>
                                    <th class="text-center">Floating Stock</th>
                                    <th class="text-center">Total Stock</th>
                                    {{-- <th>Last Update</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ProductStocks as $key => $ProductStock)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td >
                                        <a href="{{ route('inventory-histories.index', [ 'product_id' => $ProductStock->product_id ]) }}"> {{ $ProductStock->ProductName }}</a>

                                    </td>
                                    <td >{{ $ProductStock->ProductCode }}</td>
                                    <td class="text-center">
                                        {{ $ProductStock->ProductIN -  $ProductStock->ProductOUT  }} {{ $ProductStock->UnitName }}
                                    </td>
                                    <td class="text-center">
                                       {{  $ProductStock->FloatingQuantity }} {{ $ProductStock->UnitName }}
                                    </td>
                                    <td class="text-center">
                                       {{ ($ProductStock->ProductIN - $ProductStock->ProductOUT) + $ProductStock->FloatingQuantity }} {{ $ProductStock->UnitName }}
                                     </td>
                                    {{-- <td>{{ Carbon\Carbon::parse($ProductStock->LastUpdated)->format('d-m-Y h:i A') }}</td> --}}
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

    $(document).ready(function(){
        $('#location_id').change(function(){
            let locationID = $(this).val();
            window.location.replace("{{ route('inventories.index')}}?location_id=" + locationID + "");
        });
    });

</script>
@endpush
