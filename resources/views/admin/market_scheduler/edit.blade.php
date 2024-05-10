@extends('layouts.master')
@section('content')
    @if (session('status'))
    <div class="alert alert-success">{{ session('status')}}</div>
    @endif
    <div class="card">
        <div class="card-body">
        @if(isset($item))
            {!! Form::model($item, ['route'=>["marketscheduler.update", $item->id],'method' =>'PUT', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
            @endif
            <form class="custom-validation" action="#">
                <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('trading_open_day', 'Trading Open Day') !!}
                </div>
                    <div class="col-md-5">         
                    <div class="form-group">
                      {!! Form::select('trading_open_day', $day,isset($item->trading_open_day) ? $item->trading_open_day : NULL,['class'=> 'form-control']) !!}
                      {!! $errors->first('trading_open_day', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div> 
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('open_time', 'Open Time') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                          {!! Form::time('open_time', null,['class'=>'form-control']) !!}
                            {!! $errors->first('open_time','<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('close_time', 'Close Time') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::time('close_time', null,['class'=>'form-control']) !!}
                            {!! $errors->first('close_time','<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('trading_close_day', 'Trading Close Day') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                          {!! Form::select('trading_close_day', $day,isset($item->trading_close_day) ? $item->trading_close_day : NULL,['class'=> 'form-control']) !!}   
                            {!! $errors->first('trading_close_day','<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('', 'Status') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::select('status', $isActivestatus,isset($item->status) ? $item->status : NULL,['class'=> 'form-control']) !!}
                            {!! $errors->first('status', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('comments', 'Comments') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('comments', null,['class'=>'form-control']) !!}
                            {!! $errors->first('comments', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 text-right">
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div> <!-- end col -->
    @endsection