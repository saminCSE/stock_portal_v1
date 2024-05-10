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
                {!! Form::model($item, ['route' => ["newsletter.update", $item->id],'method' =>'PUT', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
            @else
                {!! Form::open(['route' => ["newsletter.store"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
            @endif
            <form class="custom-validation" action="#">
            <div class="row">
                <div class="col-md-3 text-right">
                    {!! Form::label('email', 'Email') !!} 
                </div>
                    <div class="col-md-5">
                    <div class="form-group">
                      {!! Form::text('email',isset($item->email) ? $item->email : NULL,['class'=>'form-control','disabled' => 'disabled']) !!}
                      {!! $errors->first('email', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-3 text-right">
                {!! Form::label('', 'Status') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::select('is_active', $activestatus,isset($item->is_active) ? $item->is_active : NULL,['class'=> 'form-control']) !!}
                            {!! $errors->first('is_active', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                <div class="col-md-3 text-right">
                {!! Form::label('', 'Promotion Status') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::select('is_promotion', $promotionstatus,isset($item->is_promotion) ? $item->is_promotion : NULL,['class'=> 'form-control']) !!}
                            {!! $errors->first('is_promotion', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 text-right">
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