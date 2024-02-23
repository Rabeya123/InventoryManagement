@extends('layouts.guest')

@section('title', 'Bondstein || Requsition Details')

@push('styles')
    <style>
        @media print {
            /*  .pagebreak { page-break-before: always; } /* page-break-after works, as well */
            /* .print-seciton { margin-top: 50px; } */
            .preloader-backdrop{ display: none }
            .font-size-14{font-size: 14px;}
        }
    </style>
@endpush

@section('content')
<div class="page-content fade-in-up print-seciton">
    <div class="row">
        <div class="col-md-12">

            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title"><b>Purchase Order:</b> {{ $PurchaseOrder->title }}</div>
                    <div class="ibox-tools"><b>Order No.: {{ $PurchaseOrder->code }}</b></div>

                </div>
                <div class="ibox-body">

                    <div class="col-xl-12">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th colspan="2" width="60%">Supplier's Information</th>
                                    <th colspan="2">Company Information</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Name</td>
                                    <td>{{ $PurchaseOrder->contact->contactable->name }}</td>
                                    <td>Date: </td>
                                    <td>{{ $PurchaseOrder->date }}</td>

                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>{{ $PurchaseOrder->contact->contactable->address }}</td>
                                    <td>Name:</td>
                                    <td>Bondstein Technologies Ltd.</td>
                                </tr>

                                <tr>

                                    <td>Contact Person</td>
                                    <td>{{ $PurchaseOrder->contact->name }} </td>
                                    
                                    <td>Mobile: </td>
                                    <td></td>

                                </tr>

                                <tr>

                                    <td>Contact Person Mobile</td>
                                    <td>{{ $PurchaseOrder->contact->mobile }} 
                                    </td>
                                    <td>Address: </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Shipping address:</td>
                                    <td colspan="3">{{ $PurchaseOrder->shipping_address->details }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-xl-12 mt-1 text-justify"> 
                        <p class="font-size-14">Dear Concern, <br>
                            This purchase order is subject to Bondstein Technologies Ltd. general conditions of purchase, a copy of which has been supplied to you and/or is available from Bondstein Technologies Ltd. on request. All deliveries must be accompanied by a delivery note quoting the PO ID number, item name, details and quantity of goods. If these conditions are not met the delivery may be refused. The PO ID number must be quoted on the delivery note and invoices as reference. Failure to do so may cause delays in payment. Thank you for doing business with us.</p>
                    </div>
                    <div class="col-xl-12 mt-1"> 
                        <h5 class="font-strong"> <u>Item details:</u></h5>
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item Name </th>
                                    <th class="text-center">Unit Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $toal_vat = 0;
                                $total = 0 + $PurchaseOrder->service_charge + $PurchaseOrder->others_charge;
                                $others_amount = $PurchaseOrder->service_charge + $PurchaseOrder->others_charge;
                            @endphp  
                               @foreach ($PurchaseOrder->orders as $key => $Product)
                                    @php
                                        $toal_vat += $Product->amount_tax;
                                        $total += $Product->amount_with_tax;
                                    @endphp     
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $Product->product->name }} <br><small>{{ $Product->product->description }}</small> </td>
                                        <td class="text-center">{{ number_format($Product->purchase_price, 2) }}</td>
                                        <td class="text-center">{{ $Product->quantity }} {{ $Product->product->unit->name }}</td>
                                        <td class="text-right">{{ number_format($Product->amount, 2) }}</td>
                                    </tr>
                               @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right">TOTAL AMOUNT :</td>
                                    <td class="text-right"> {{ number_format($PurchaseOrder->order_total, 2) }}</td>
                               </tr>
                               <tr>
                                    <td colspan="4" class="text-right">TOTAL VAT:</td>
                                    <td class="text-right"> {{ number_format($toal_vat, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right">SERVICE & OTEHRS CHARGE:</td>
                                    <td class="text-right"> {{ number_format($others_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">GRAND  TOTAL	:</th>
                                    <th class="text-right"> {{ number_format($total, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="col-xl-12 mt-5"> 
                        
                        <h6 class="font-strong">Conditions/Notes:</h6>
                        @foreach ($PurchaseOrder->conditions as $key =>  $Condition)
                           {{ $key + 1 }} . {{ $Condition->name }}    <br>
                        @endforeach
                    </div>

                    <div class="col-xl-12 mt-3 pt-5 mb-5"> 
                        <div class="row">
                            <div class="col-6">
                                Prepared by <br>
                               <b> ({{ $PurchaseOrder->created_user->name }})</b> <br>
                               {{ $PurchaseOrder->created_user->role->name }} <br>
                               Bondstein Technologies Ltd.
                            </div>
                            <div class="col-6 text-right">
                                Checked by <br>
                                <b> ({{ $PurchaseOrder->approved_user->name }})</b> <br>
                                {{ $PurchaseOrder->approved_user->role->name }} <br>
                                Bondstein Technologies Ltd.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@push('scripts')
    
    <script>
        $(document).ready(function() {
            window.print();
        });
    </script>

@endpush

