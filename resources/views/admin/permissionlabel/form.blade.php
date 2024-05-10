@extends('layouts.master')

@section('css')
    <!-- Plugin css -->
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet"
          type="text/css"/>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            @if(isset($item))
                {!! Form::model($item, ['route' => ["permissionlabel.update", $item->id],'method' =>'PUT', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
            @else
                {!! Form::open(['route' => ["permissionlabel.store"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
            @endif
            <form class="custom-validation" action="#">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('label_name ', ' Label Name') !!} <span class="la-required">*</span>
                            {!! Form::text('label_name', null,['class'=>'form-control', 'placeholder'=>'Label Name']) !!}
                            {!! $errors->first('label_name', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('name', 'Label Check') !!} <span class="la-required">*</span>
                            {!! Form::text('name', null,['class'=>'form-control', 'placeholder'=>'Label Check']) !!}
                            {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
               
               
               
             
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                    Submit
                                </button>
                                <a href={{route('permissionlabel.index')}}>
                                    <button type="button" class="btn btn-secondary waves-effect">
                                        Cancel
                                    </button>
                                </a>
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
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>

    <script type="text/javascript">
     $('.datepicker').datepicker({
                autoclose:true,
                todayHighlight:true,
                format:'yyyy-mm-dd',
            });
    </script>
@endsection