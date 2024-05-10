@extends('layouts.master')
@section('css')
<!-- datatables css -->
<!-- <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/> -->
<link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
<style>
    table,
    td,
    th {
        vertical-align: middle !important;
    }

    table th {
        font-weight: bold;
    }
</style>
@endsection
@section('content')
@if (session('status'))
<div class="alert alert-success">{{ session('status')}}</div>
@endif
<div class="card">
  <div class="box-header with-border col-6 text-right">
                <h3 class="box-title">Add Daily Data</h3>
            </div>
    <div class="card-body">
        @if(isset($item))
        {!! Form::model($item, ['route'=>["dailyData.update_dailyData", $item->id],'method' =>'PUT', 'enctype'=>'multipart/form-data', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
        @else
        {!! Form::open(['route' => ["dailyData.store"],'method'=>'POST', 'enctype'=>'multipart/form-data', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
        @endif

        <form class="custom-validation" action="#" enctype="multipart/form-data">
        <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('Market','Market') !!}
                </div>
                <div class="col-lg-5">
                    <div class="form-group">
                        {!! Form::select('market_id', $market,isset($item->market_id) ? $item->market_id : NULL,['class'=> 'form-control',  'readonly' => isset($item)]) !!}
                        {!! $errors->first('market_id', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>   
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('Instrument Name', 'Instrument Name') !!}
                </div>
                <div class="col-lg-5">
                    <div class="form-group">

                        {!! Form::select('instrument_id', $instrument,isset($item->instrument_id) ? $item->instrument_id : NULL,['class'=> 'form-control', 'readonly' => isset($item)]) !!}
                        {!! $errors->first('instrument_id', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('Quote_bases','Quote_bases') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('quote_bases',isset($item->quote_bases) ? $item->quote_bases : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('quote_bases', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('open_price','Open Price') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('open_price',isset($item->open_price) ? $item->open_price : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('open_price', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('pub_last_traded_price','Pub Last Traded Price') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('pub_last_traded_price', isset($item->pub_last_traded_price) ? $item->pub_last_traded_price : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('pub_last_traded_price', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('spot_last_traded_price','Spot Last Traded Price') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('spot_last_traded_price', isset($item->spot_last_traded_price) ? $item->spot_last_traded_price : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('spot_last_traded_price', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('high_price','HIgh Price') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('high_price',isset($item->high_price) ? $item->high_price : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('high_price', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('low_price','Low Price') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('low_price',isset($item->low_price) ? $item->low_price : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('low_price', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('close_price','Close Price') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('close_price',isset($item->close_price) ? $item->close_price : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('close_price', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('yday_close_price','Yday Close Price') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('yday_close_price',isset($item->yday_close_price) ? $item->yday_close_price : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('yday_close_price', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('total_trades','Total Trades') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('total_trades',isset($item->total_trades) ? $item->total_trades : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('total_trades', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('total_volume','Total Volume') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('total_volume',isset($item->total_volume) ? $item->total_volume : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('total_volume', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('new_volume','New Volume') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('new_volume',isset($item->new_volume) ? $item->new_volume : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('new_volume', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('total_value','Total Value') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('total_value',isset($item->total_value) ? $item->total_value : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('total_value', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('public_total_trades','Public Total Trades') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('public_total_trades',isset($item->public_total_trades) ? $item->public_total_trades : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('public_total_trades', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('public_total_volume','Public Total Volume') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('public_total_volume',isset($item->public_total_volume) ? $item->public_total_volume : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('public_total_volume', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('public_total_value','Public Total Value') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('public_total_value',isset($item->public_total_value) ? $item->public_total_value : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('public_total_value', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('spot_total_trades','Spot Total Trades') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('spot_total_trades',isset($item->spot_total_trades) ? $item->spot_total_trades : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('spot_total_trades', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('spot_total_volume','Spot Total Volume') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('spot_total_volume',isset($item->spot_total_volume) ? $item->spot_total_volume : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('spot_total_volume', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('spot_total_value','Spot Total Value') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('spot_total_value',isset($item->spot_total_value) ? $item->spot_total_value : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('spot_total_value', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('lm_date_time','Lm Date') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::datetime('lm_date_time',isset($item->lm_date_time) ? $item->lm_date_time : NULL,['class'=> 'form-control datepicker']) !!}
                        {!! $errors->first('lm_date_time', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('trade_time','Trade Time') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::time('trade_time',isset($item->trade_time) ? $item->trade_time : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('trade_time', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('trade_date','Trade Date') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('trade_date',isset($item->trade_date) ? $item->trade_date : NULL,['class'=> 'form-control datepicker']) !!}
                        {!! $errors->first('trade_date', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('batch','Batch') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('batch',isset($item->batch) ? $item->batch : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('batch', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 text-right">
                    <div class="form-group mb-0">
                        <div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div> <!-- end col -->
@endsection

@section('script')
<!-- Plugins js -->
<!-- <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js')}}"></script> -->
<script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script>
    
    $(function() {
        $('.datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
        });
    });
</script>
@endsection