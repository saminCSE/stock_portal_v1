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
                <h3 class="box-title">Add Data Bank Eod</h3>
            </div>
    <div class="card-body">
        @if(isset($item))
        {!! Form::model($item, ['route'=>["DataEod.update_DataEod", $item->id],'method' =>'PUT', 'enctype'=>'multipart/form-data', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
        @else
        {!! Form::open(['route' => ["DataEod.store"],'method'=>'POST', 'enctype'=>'multipart/form-data', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
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

                        {!! Form::select('instrument_id', $instrument,isset($item->instrument_id) ? $item->instrument_id : NULL,['class'=> 'form-control','readonly' => isset($item)])!!}
                        {!! $errors->first('instrument_id', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('Sector Name', 'Sector Name') !!}
                </div>
                <div class="col-lg-5">
                    <div class="form-group">

                        {!! Form::select('sector_id', $sector,isset($item->sector_id) ? $item->sector_id : NULL,['class'=> 'form-control','readonly' => isset($item)])!!}
                        {!! $errors->first('sector_id', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('open','Open') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('open',isset($item->open) ? $item->open : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('open', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('high','High') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('high',isset($item->high) ? $item->high : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('high', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('low','Low') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('low', isset($item->low) ? $item->low : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('low', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('close','Close') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('close', isset($item->close) ? $item->close : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('close', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('ycp','Ycp') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('ycp',isset($item->ycp) ? $item->ycp : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('ycp', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('volume','Volume') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('volume',isset($item->volume) ? $item->volume : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('volume', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('trade','Trade') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('trade',isset($item->trade) ? $item->trade : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('trade', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('tradevalues','Tradevalues') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('tradevalues',isset($item->tradevalues) ? $item->tradevalues : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('tradevalues', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
          
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('date','Date') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('date',isset($item->date) ? $item->date : NULL,['class'=> 'form-control datepicker']) !!}
                        {!! $errors->first('date', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('updated','Updated') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('updated',isset($item->updated) ? $item->updated : NULL,['class'=> 'form-control datepicker']) !!}
                        {!! $errors->first('updated', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('market_instrument','Market Instrument') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('market_instrument',isset($item->market_instrument) ? $item->market_instrument : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('market_instrument', '<p class="help-block text-danger">:message</p>') !!}
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