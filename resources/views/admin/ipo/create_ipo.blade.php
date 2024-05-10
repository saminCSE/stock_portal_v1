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
    @if (session('status'))
    <div class="alert alert-success">{{ session('status')}}</div>
    @endif
    <div class="card">
        <div class="card-body">
        @if(isset($item))
            {!! Form::model($item, ['route'=>["ipo.update_ipo", $item->id],'method' =>'PUT',  'enctype'=>'multipart/form-data', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
            @else
            {!! Form::open(['route' => ["ipo.create_ipo"], 'method'=>'POST', 'enctype'=>'multipart/form-data', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
            @endif

            <form class="custom-validation" action="#" enctype="multipart/form-data">
                <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('name', 'Ipo Name') !!}
                </div>
                    <div class="col-md-5">
                    <div class="form-group">
                            {!! Form::text('name', null,['class'=> 'form-control']) !!}
                            {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('board', 'Board Name') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">

                            {!! Form::select('board', $ipoboard,isset($item->board) ? $item->board : NULL,['class'=> 'form-control']) !!}
                            {!! $errors->first('board', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('asset_class', 'Asset Class') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">

                            {!! Form::select('asset_class', $asset_class,isset($item->asset_class) ? $item->asset_class : NULL,['class'=> 'form-control']) !!}
                            {!! $errors->first('asset_class', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('methods', 'Method') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::select('methods', $methods,isset($item->methods) ? $item->methods : NULL,['class'=> 'form-control']) !!}
                            {!! $errors->first('methods', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('','Status') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::select('status', $ipo_status, isset($item->status) ? $item->status : NULL,['class'=> 'form-control']) !!}
                            {!! $errors->first('status', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('ipo_size', 'IPO Size(BDT mn)') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('ipo_size', null,['class'=>'form-control']) !!}
                            {!! $errors->first('ipo_size', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('offer_price', 'Offer Price') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('offer_price', null,['class'=>'form-control']) !!}
                            {!! $errors->first('offer_price', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('Open_date', 'Subscription Open Date') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('Open_date', null,['class'=>'form-control datepicker']) !!}
                            {!! $errors->first('Open_date', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('close_date', 'Subscription Close Date') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('close_date', null,['class'=>'form-control datepicker']) !!}
                            {!! $errors->first('close_date', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('summary', 'Summary') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::file('summary', null,['class'=>'form-control']) !!}
                            {!! $errors->first('summary', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                        <div>
                        @if(isset($item))
                        <a href="{{route('ipo.summarydownload',['id'=>$item->id])}}">{{$item->summary}} <i class="fa fa-download" aria-hidden="true"></i></a>
                         @endif
                        </div>
                        <br>
                    </div>
                </div>

                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('prospectors', 'Prospectors') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::file('prospectors', null,['class'=>'form-control']) !!}
                            {!! $errors->first('prospectors', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                        <div>
                        @if(isset($item))
                        <a href="{{route('ipo.prospectorsdownload',['id'=>$item->id])}}">{{$item->prospectors}} <i class="fa fa-download" aria-hidden="true"></i></a>
                    @endif
                        </div>
                        <br>
                    </div>
                </div>

                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('results', 'Results') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::file('results', null,['class'=>'form-control']) !!}
                            {!! $errors->first('results', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                        <div>
                        @if(isset($item))
                        <a href="{{route('ipo.resultsdownload',['id'=>$item->id])}}">{{$item->results}}<i class="fa fa-download" aria-hidden="true"></i>
                    @endif
                        </div>
                        <br>
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
