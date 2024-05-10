@extends('layouts.master')
@section('content')
    @if (session('status'))
    <div class="alert alert-success">{{ session('status')}}</div>
    @endif
    <div class="card">
        <div class="card-body">
        @if(isset($item))
                {!! Form::model($item, ['route' => ["instrument.update_instrument", $item->id],'method' =>'PUT', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
            @endif
            <form class="custom-validation" action="#">
                <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('exchange_id', 'Exchange Name') !!}
                </div>
                    <div class="col-md-5">
                    <div class="form-group">
                            {!! Form::select('exchange_id', $exchange, isset($item->exchange_id) ? $item->exchange_id : NULL,['class'=> 'form-control']) !!}
                            {!! $errors->first('exchange_id', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('sector_list_id', 'Sector Name') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">

                            {!! Form::select('sector_list_id', $sector,isset($item->sector_list_id) ? $item->sector_list_id : NULL,['class'=> 'form-control']) !!}
                            {!! $errors->first('sector_list_id', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                  <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('name', 'Instrument Name') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">

                            {!! Form::text('name',isset($item->name) ? $item->name : NULL,['class'=> 'form-control']) !!}
                            {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('instrument_code', 'Instrument Code') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                        {!! Form::text('instrument_code',isset($item->instrument_code) ? $item->instrument_code : NULL,['class'=> 'form-control']) !!}
                            {!! $errors->first('instrument_code', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                     <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('category', 'Category') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                        {!! Form::text('category',isset($item->category) ? $item->category : NULL,['class'=> 'form-control']) !!}
                            {!! $errors->first('category', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('isin', 'IsIn') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('isin', null,['class'=>'form-control']) !!}
                            {!! $errors->first('isin', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('is_spot', 'IS spot') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                           {!! Form::select('is_spot',$isstatus,isset($item->is_spot) ? $item->is_spot : 1,['class' => 'form-control']) !!}
                            {!! $errors->first('is_spot', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('active', 'Status') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::select('active',$isActivestatus,isset($item->active) ? $item->active : 1,['class' => 'form-control']) !!}
                            {!! $errors->first('active', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-2 text-right">
                        <label for="index">Index</label>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <div class="checkbox-inline">
                                <label>
                                    <input type="checkbox" name="index[]" value="DSEX" {{ $item->isdsex == '1' ? 'checked' : '' }}> DSEX
                                </label>
                            </div>
                            <div class="checkbox-inline">
                                <label>
                                    <input type="checkbox" name="index[]" value="DSES" {{ $item->isdses == '1' ? 'checked' : '' }}> DSES
                                </label>
                            </div>

                            <div class="checkbox-inline">
                                <label>
                                    <input type="checkbox" name="index[]" value="DS30" {{ $item->isds30 == '1' ? 'checked' : '' }}> DS30
                                </label>
                            </div>
                            <p class="help-block text-danger">
                                {{ $errors->first('index') }}
                            </p>
                        </div>
                    </div>
                </div>


                <!-- <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('batch_id', 'Batch Id') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">

                            {!! Form::number('batch_id', null,['class'=>'form-control']) !!}
                            {!! $errors->first('batch_id', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div> -->


                    <!-- <div class="row">
                    <div class="col-md-2 text-right">
                    {!! Form::label('market_id', 'Market Id') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">

                            {!! Form::number('market_id', null,['class'=>'form-control']) !!}
                            {!! $errors->first('market_id', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>

                </div> -->

                <div class="row">
                    <div class="col-lg-5 text-right">
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
