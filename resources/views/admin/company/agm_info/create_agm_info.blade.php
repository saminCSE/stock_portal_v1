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
                <h3 class="box-title">Add Company AGM Information</h3>
            </div>
    <div class="card-body">
        @if(isset($item))
        {!! Form::model($item, ['route'=>["company_agm.update", $item->id],'method' =>'PUT','enctype'=>'multipart/form-data', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
        @else
        {!! Form::open(['route' => ["company_agm.store"],'method'=>'POST', 'enctype'=>'multipart/form-data', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
        @endif
        <form class="custom-validation" action="#">
        <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('company_id', 'Company Name') !!}
                </div>
                <div class="col-lg-5">
                    <div class="form-group">
                        {!! Form::select('company_id', $company,isset($item->company_id) ? $item->company_id : NULL,['class'=> 'form-control']) !!}
                        {!! $errors->first('company_id', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('last_agm_held_on','Last Agm Held') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('last_agm_held_on', null,['class'=> 'form-control yearpicker']) !!}
                        {!! $errors->first('last_agm_held_on', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('right_issue','Right Issue') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('right_issue', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('right_issue', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('year_end','Year End') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('year_end', null,['class'=> 'form-control datepicker']) !!}
                        {!! $errors->first('year_end', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('reserve_surplus','Reserve Surplus') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('reserve_surplus', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('reserve_surplus', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('comprehensive_income','Comprehensive Income') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('comprehensive_income', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('comprehensive_income', '<p class="help-block text-danger">:message</p>') !!}
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
        $('.yearpicker').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        });
    });
    $(function() {
        $('.datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
        });
    });
</script>
@endsection