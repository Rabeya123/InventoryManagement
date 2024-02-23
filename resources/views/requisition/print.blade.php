@extends('layouts.guest')

@section('title', 'Bondstein || Requsition Details')

@push('styles')
    <style>
        @media print {
            .pagebreak { page-break-before: always; } /* page-break-after works, as well */
            .print-seciton { margin-top: 100px; }
            .preloader-backdrop{ display: none }
        }
    </style>
@endpush

@section('content')
<div class="page-content pt-2 fade-in-up print-seciton">
    <div class="row">
        <div class="col-md-12">

            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Delivery Challan</div>
                   
                </div>
                <div class="ibox-body">

                    <div class="col-xl-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="2" width="50%">Sender</th>
                                    <th colspan="2">Client/Technician</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Date: </td>
                                    <td>{{ $Requisition->date }}</td>
                                    <td>Name:</td>
                                    <td>{{ $Requisition->requisition_for->name }}</td>
                                </tr>
                                <tr>
                                    <td>Challan/Ref. No: </td>
                                    <td><b>{{ $Requisition->code }}</b></td>
                                    <td>Mobile: </td>
                                    <td>{{ $Requisition->requisition_for->mobile }}</td>
                                </tr>

                                <tr>
                                    <td>Name</td>
                                    <td>Bondstein Technologies Ltd.</td>
                                    <td>Address: </td>
                                    <td>{{ $Requisition->requisition_for->address }}</td>
                                </tr>

                                <tr>
                                    <td>Delivery from:</td>
                                    <td>{{ $Requisition->location->name }}</td>
                                    <td>Shipping address: </td>
                                    <td>{{ $Requisition->requisition_for->address }}</td>
                                </tr>

                                
                                <tr>
                                    <td>Note:</td>
                                    <td colspan="3">{{ $Requisition->description }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-xl-12 mt-1 text-justify"> 
                        <p>Dear Concern, <br>
                            This challan document is subject to Bondstein Technologies Ltd.’s general conditions of delivery, a copy of which has been supplied to you and is available from Bondstein Technologies Ltd. on request. All deliveries must be received by a delivery note/seal. This delivery is made at the request of the VTS contract or service purchase of the concern.
                        </p>
                    </div>
                    <div class="col-xl-12 mt-1"> 
                        <h5 class="font-strong"> <u>Item details:</u></h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item Name</th>
                                    <th>Item Details</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($Requisition->products as $key => $Product)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $Product->product->name }}</td>
                                        <td>{{ $Product->product->description }}</td>
                                        <td>{{ $Product->quantity }} {{ $Product->product->unit->name }}</td>
                                    </tr>
                               @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">Total:</th>
                                    <th>{{ $Requisition->products->sum('quantity') }} Unit</th>
                               </tr>
                            </tfoot>
                        </table>

                    </div>

                    <div class="col-xl-12 mt-5 pt-5 mb-5"> 
                        <div class="row">
                            <div class="col-6">
                                Prepared/Checked by <br>
                               <b> ({{ $Requisition->requisition_by->name }})</b> <br>
                               {{ $Requisition->requisition_by->role->name }} <br>
                               Bondstein Technologies Ltd.
                            </div>
                            <div class="col-6 text-right">
                               <div class="mt-5"><b>Received by name & date</b> <br></div>
                            </div>
                        </div>
                    </div>

                    @if (COUNT($Requisition->indentifiers) > 0)
                        <div class="col-xl-12 pagebreak print-seciton">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="2" width="50%">Sender</th>
                                        <th colspan="2">Client/Reciver</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Date: </td>
                                        <td>{{ $Requisition->date }}</td>
                                        <td>Name:</td>
                                        <td>{{ $Requisition->requisition_for->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Challan/Ref. No: </td>
                                        <td><b>{{ $Requisition->code }}</b></td>
                                        <td>Mobile: </td>
                                        <td>{{ $Requisition->requisition_for->mobile }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-xl-12">
                            <h5 class="font-strong"> <u>Item identification details:</u></h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        {{-- <th>Batch Number</th> --}}
                                        <th>Code/IMEI</th>
                                        <th>Secondary Code/BSTI</th>
                                    </tr>
                                </thead>
                                    <tbody id="table_body">
                                        @foreach ($Requisition->indentifiers as $key => $indentifier)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $indentifier->product->name }}</td>
                                            {{-- <td>{{ $indentifier->batch->code }}</td> --}}
                                            <td>{{ $indentifier->code }}</td>
                                            <td>{{ $indentifier->secondary_code }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="5" class="text-center">Total quantity: {{ $Requisition->indentifiers->count('id') }} Unit</th>
                                        </tr>
                                    </tbody>
                            </table>
                        </div>
                    @endif
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

