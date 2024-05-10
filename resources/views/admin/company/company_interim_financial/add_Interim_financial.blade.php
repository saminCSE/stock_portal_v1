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
                <h3 class="box-title"> Add Company Interim Financial</h3>
            </div>
    <div class="card-body">
        @if(isset($item))
        {!! Form::model($item, ['route'=>["company_interim.update", $item->id],'method' =>'PUT', 'enctype'=>'multipart/form-data', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
        @else
        {!! Form::open(['route' => ["company_interim.store"], 'method'=>'POST', 'enctype'=>'multipart/form-data', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
        @endif
        <form class="custom-validation" action="#" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('company_id','Company Name') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                     {!! Form::select('company_id', $company,isset($item->company_id) ? $item->company_id : NULL,['class'=> 'form-control']) !!}
                     {!! $errors->first('company_id', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('turnover','Turnover') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('turnover', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('turnover', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('pfco','PFCO') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('pfco', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('pfco', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('pftp','PFTP') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('pftp', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('pftp', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('tcip','TCIP') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('tcip', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('tcip', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('basic_eps','Basic EPS') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('basic_eps', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('basic_eps', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('diluted_eps','Diluted EPS')!!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('diluted_eps', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('diluted_eps', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('basic_epsco','Basic EPSCO') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('basic_epsco', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('basic_epsco', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('diluted_epsco','Diluted EPSCO') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('diluted_epsco', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('diluted_epsco', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('mppspe', 'MPPSPE') !!}
                </div>
                <div class="col-lg-5">
                    <div class="form-group">
                       {!! Form::text('mppspe', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('mppspe', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('q1','Q1') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('q1', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('q1', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('q2','Q2') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('q2', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('q2', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('half_yearly','Half Yearly') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('half_yearly', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('half_yearly', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('q3','Q3') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('q3', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('q3', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('nine_months','Nine Months') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('nine_months', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('nine_months', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('annual','Annual') !!}
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::text('annual', null,['class'=> 'form-control']) !!}
                        {!! $errors->first('annual', '<p class="help-block text-danger">:message</p>') !!}
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
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        });
    });
</script>
@endsection