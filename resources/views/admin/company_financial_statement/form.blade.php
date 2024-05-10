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
    <div class="row justify-content-center">
        <h2>Create Company Financial Statement</h2>
    </div>
    <div class="card">
        <div class="card-body">
            @if(isset($item))
                {!! Form::model($item, ['route'=>["company_financial_statement.update", $item->id],'method' =>'PUT', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
            @else
                {!! Form::open(['route' => ["company_financial_statement.store"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
            @endif

            <form class="custom-validation" action="#">

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('symbol', 'Instrument Name') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::select('instrument_id', $instruments,isset($item->instrument_id)?$item->instrument_id:0,['class'=>'form-control select2']) !!}
                            {!! $errors->first('symbol', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('date_time', 'Date') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('date_time', isset($item->date_time)?$item->date_time:null,['class'=>'form-control datepicker']) !!}

                            {!! $errors->first('date_time', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('quatar_text', 'Quatar') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('quatar_text', null,['class'=>'form-control']) !!}
                            {!! $errors->first('quatar_text', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('file', 'File') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::file('file', null,['class'=>'form-control']) !!}
                            {!! $errors->first('file', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('is_active', 'Status') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::select('is_active', $is_active,isset($item->is_active)?$item->is_active:1,['class'=>'form-control']) !!}
                            {!! $errors->first('is_active', '<p class="help-block text-danger">:message</p>') !!}
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
        $(function () {
            $('.datepicker').datepicker({
                autoclose:true,
                todayHighlight:true,
                format:'yyyy-mm-dd',
            });

        });
    </script>

@endsection
