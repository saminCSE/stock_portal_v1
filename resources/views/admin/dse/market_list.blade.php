@extends('layouts.master')

@section('css')
    <!-- datatables css -->
    <!-- <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/> -->
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet"
          type="text/css"/>

    <style>

        table, td, th {
            vertical-align: middle !important;
         }
         table th {
            font-weight: bold;
         }

    </style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                {!! Form::open(['route' => ["market.list"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'form_custom']) !!}

                <div class="row ">
                <div class="col-lg-4">
                        <div class="form-group">
                            {!! Form::label('From Date', ' From Date') !!}
                            {!! Form::text('from_date',$fromDate,['class'=>'form-control datepicker', 'placeholder'=>'From Date','required'=>'required']) !!}
                            {!! $errors->first('from_date', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            {!! Form::label('To Date', ' To Date') !!}
                            {!! Form::text('to_date', $toDate,['class'=>'form-control datepicker', 'placeholder'=>'To Date','required'=>'required']) !!}
                            {!! $errors->first('to_date', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <div style="margin-top: 30px;">
                                <button type="submit" id="btn_search" class="btn btn-primary waves-effect waves-light mr-1">
                                    Search
                                </button>

                            </div>
                        </div>
                    </div>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="card shadow mb-12">
    @if (session('status'))
    <div class="alert alert-success">{{ session('status')}}</div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="th-sm">ID</th>
                                <th class="th-sm">Trade date</th>
                                <th class="th-sm">Trade Today</th>
                                <th class="th-sm">Market Started</th>
                                <th class="th-sm">Market Closed</th>
                                <th class="th-sm">Comments</th>
                                <th class="th-sm">Excchange</th>
                                <th class="th-sm">Data Bank Intraday Batch</th>
                                <th class="th-sm">Batch Total Trade</th>
                                <th class="th-sm">Total Trade</th>
                                <th class="th-sm">Total Volume</th>
                                <th class="th-sm">Total Value</th>
                                <th class="th-sm">Date Time</th>
                            </tr>
                        </thead>

                        <tbody>
                        @php 
                            $sr = ($market->currentpage()-1) * $market->perpage();
                        @endphp

                        @foreach($market as $key=>$list)
                            <tr>
                               <td> {{ $sr + $key + 1 }} </td>
                                <td>{{$list->trade_date}}</td>
                                <td> @if($list->is_trading_day==1)
                                    <a class="btn btn-sm btn-success text-white ">Yes</a>
                                    @elseif($list->is_trading_day==0)
                                    <a class="btn btn-sm btn-danger text-white">No</a>
                                    @endif
                                </td>
                                <td>{{$list->market_started}}</td>
                                <td>{{$list->market_closed}}</td>
                                <td>{{$list->comments}}</td>
                                <td> @if($list->exchange_id==1)
                                    <a class="btn btn-sm">DSE</a>
                                    @elseif($list->exchange_id==2)
                                    <a class="btn btn-sm">CSE</a>
                                    @endif
                                </td>
                                <td>{{$list->data_bank_intraday_batch}}</td>
                                <td>{{$list->batch_total_trades}}</td>
                                <td>{{$list->trd_total_trades}}</td>
                                <td>{{$list->trd_total_volume}}</td>
                                <td>{{$list->trd_total_value}}</td>
                                <td>{{$list->time}}</td>
                            </tr>
                            @endforeach
                   @if(!count($market)) 
                            <tr class="row1">
                                <td colspan="8" class="text-center"> No record found. </td>
                               
                            </tr>
                        
                        @endif
                        </tbody>
                    </table>
                    <div class="pagination_link">
                        {{ $market->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

<!-- Plugins js -->
<!-- <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
<script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js')}}"></script> -->
<script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script>
    $(function () {
        $('.datepicker').datepicker({
            autoclose:true,
            todayHighlight:true,
            format:'yyyy-mm-dd',
        }); 
    });
</script>
@endsection