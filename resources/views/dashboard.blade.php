@extends('layouts.master')

@section('content')

  <!-- START PAGE CONTENT-->
  <div class="page-content fade-in-up">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-success color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">{{  $TotalProductInCount - $TotalProductOutCount }}</h2>
                    <div class="m-b-5">TOTAL INHOUSE PRODUCT</div><i class="ti-layout-grid4-alt widget-stat-icon"></i>
                    {{-- <div><i class="fa fa-level-up m-r-5"></i><small>25% higher</small></div> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-info color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">{{  $TotalProductInCount }}</h2>
                    <div class="m-b-5">TOTAL PRODUCT IN</div><i class="ti-layout-grid4-alt widget-stat-icon"></i>
                    {{-- <div><i class="fa fa-level-up m-r-5"></i><small>17% higher</small></div> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-warning color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">{{ $TotalProductOutCount }}</h2>
                    <div class="m-b-5">TOTAL PRODUCT OUT</div><i class="ti-layout-grid4-alt widget-stat-icon"></i>
                    {{-- <div><i class="fa fa-level-up m-r-5"></i><small>22% higher</small></div> --}}
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-danger color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">{{ $TotalFloatingCount ? $TotalFloatingCount : 0 }}</h2>
                    <div class="m-b-5">TOTAL FLOATING STOCK</div><i class="ti-layout-grid4-alt widget-stat-icon"></i>
                    {{-- <div><i class="fa fa-level-down m-r-5"></i><small>-12% Lower</small></div> --}}
                </div>
            </div>
        </div>
    @if (auth()->user()->is_admin)
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-success color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">{{ number_format($TotalProductPurchaseAmount, 2) }} BDT</h2>
                    <div class="m-b-5">TOTAL PURCHASE</div><i class="ti-package widget-stat-icon"></i>
                    {{-- <div><i class="fa fa-level-down m-r-5"></i><small>-12% Lower</small></div> --}}
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-info color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">{{ number_format($TotalProductIndentifierPurchaseAmount, 2) }} BDT</h2>
                    <div class="m-b-5">TOTAL PURCHASE(INHOUSE)</div><i class="ti-package widget-stat-icon"></i>
                    {{-- <div><i class="fa fa-level-down m-r-5"></i><small>-12% Lower</small></div> --}}
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-warning color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">{{ number_format($TotalProductPurchaseFloatingAmount ,2) }} BDT</h2>
                    <div class="m-b-5">TOTAL PURCHASE(FLOATING)</div><i class="ti-package widget-stat-icon"></i>
                    {{-- <div><i class="fa fa-level-down m-r-5"></i><small>-12% Lower</small></div> --}}
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-danger color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">{{ number_format( $TotalProductIndentifierPurchaseAmount + $TotalProductPurchaseFloatingAmount ,2) }} BDT</h2>
                    <div class="m-b-5">TOTAL CURRENT PURCHASE</div><i class="ti-package widget-stat-icon"></i>
                    {{-- <div><i class="fa fa-level-down m-r-5"></i><small>-12% Lower</small></div> --}}
                </div>
            </div>
        </div>
    @endif

        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Product History Daily</div>
                </div>
                <div class="ibox-body">
                    <div>
                        <canvas id="product_history_daily" style="height:200px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Product Current Status</div>
                </div>
                <div class="ibox-body">
                    <div>
                        <canvas id="product_current_position" style="height:200px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 ">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Sync with YBX</div>
                </div>
                <div class="ibox-body row">
                    <div class="col-md-6"> <a href="{{ route('sync.indentifier')}}" class="btn btn-success d-block">Indentifer</a></div>
                    <div class="col-md-6"><a href="{{ route('sync.customer')}}" class="btn btn-success d-block">Customer</a></div>
                    {{-- <div class="col-md-4"></div> --}}
                </div>
            </div>
          
        </div>

    </div>
</div>
<!-- END PAGE CONTENT-->

@stop

@push('scripts')

    <script src="{{asset('js/Chart.min.js')}}" type="text/javascript"></script>
    <script>
    $(function() {

        // Bar Chart example

        var barData = {
            labels: ['<?=implode("', '", array_column($ProductMovementDaily, "Date"))?>'],
            datasets: [
                {
                    label: "IN",
                    backgroundColor:'#DADDE0',
                    data: ['<?=implode("', '", array_column($ProductMovementDaily, "ProductIN"))?>']
                },
                {
                    label: "OUT",
                    backgroundColor: '#2ecc71',
                    borderColor: "#fff",
                    data: ['<?=implode("', '", array_column($ProductMovementDaily, "ProductOUT"))?>']
                }
            ]
        };
        var barOptions = {
            responsive: true,
            maintainAspectRatio: false
        };

        var ctx = document.getElementById("product_history_daily").getContext("2d");
        new Chart(ctx, {type: 'bar', data: barData, options:barOptions}); 

        //bar chart for product current position
        var barDataProductStatus = {
            labels: ['<?=implode("', '", array_column($ProductCurrentPosition, "ProductName"))?>'],
            datasets: [
                {
                    label: "Quantity",
                    backgroundColor:'#DADDE0',
                    data: ['<?=implode("', '", array_column($ProductCurrentPosition, "TotalCount"))?>']
                }
            ]
        };
        var barProductOptions = {
            responsive: true,
            maintainAspectRatio: false
        };

        var ctx = document.getElementById("product_current_position").getContext("2d");
        new Chart(ctx, {type: 'bar', data: barDataProductStatus, options:barProductOptions}); 

    });

    </script>
@endpush
