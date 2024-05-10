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
        <h2>Create Director Profile</h2>
    </div>
    <div class="card">
        <div class="card-body">
            @if(isset($item))
                {!! Form::model($item, ['route'=>["director_profile.update", $item->id],'method' =>'PUT', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
            @else
                {!! Form::open(['route' => ["director_profile.store"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
            @endif

            <form class="custom-validation" action="#">


                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('name', 'Name') !!}
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            {!! Form::text('name', isset($item->name)?$item->name:null,['class'=>'form-control']) !!}

                            {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('phone', 'Phone') !!}
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            {!! Form::text('phone', isset($item->phone)?$item->phone:null,['class'=>'form-control']) !!}

                            {!! $errors->first('phone', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('email', 'Email') !!}
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            {!! Form::text('email', isset($item->email)?$item->email:null,['class'=>'form-control']) !!}

                            {!! $errors->first('email', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('designation_id', 'Designation') !!}
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            {!! Form::select('designation_id',$designations,isset($item->designation_id) ? $item->designation_id : null,['class' => 'form-control select2']) !!}
                            {!! $errors->first('designation_id', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('description', 'Description') !!}
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            {!! Form::textarea('description', isset($item->description)?$item->description:null,['class'=>'form-control editors']) !!}

                            {!! $errors->first('description', '<p class="help-block text-danger">:message</p>') !!}
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
