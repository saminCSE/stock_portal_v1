@extends('layouts.master')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <div class="card">
        <div class="card-body">
            @if (isset($item))
                {!! Form::model($item, [
                    'route' => ['list.update_instrument', $item->id],
                    'method' => 'PUT',
                    'class' => 'custom-validation',
                    'files' => true,
                    'role' => 'form',
                    'id' => 'edit-form',
                ]) !!}
            @else
                {!! Form::open([
                    'route' => ['instrument.create_instrument'],
                    'method' => 'POST',
                    'class' => 'custom-validation',
                    'files' => true,
                    'role' => 'form',
                    'id' => 'add-form',
                ]) !!}
            @endif
            <form class="custom-validation" action="#">
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('exchange_id', 'Exchange Name') !!}
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::select('exchange_id', $exchange, isset($item->exchange_id) ? $item->exchange_id : null, [
                                'class' => 'form-control',
                            ]) !!}
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

                            {!! Form::select('sector_list_id', $sector, isset($item->sector_list_id) ? $item->sector_list_id : null, [
                                'class' => 'form-control',
                            ]) !!}
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

                            {!! Form::text('name', isset($item->name) ? $item->name : null, ['class' => 'form-control']) !!}
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
                            {!! Form::text('instrument_code', isset($item->instrument_code) ? $item->instrument_code : null, [
                                'class' => 'form-control',
                            ]) !!}
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
                            {!! Form::text('category', isset($item->category) ? $item->category : null, ['class' => 'form-control']) !!}
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
                            {!! Form::text('isin', null, ['class' => 'form-control']) !!}
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
                            {!! Form::select('is_spot', $isstatus, isset($item->is_spot) ? $item->is_spot : 1, ['class' => 'form-control']) !!}
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
                            {!! Form::select('active', $isActivestatus, isset($item->active) ? $item->active : 1, [
                                'class' => 'form-control',
                            ]) !!}
                            {!! $errors->first('active', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('index', 'Index') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            @foreach (['DSEX' => 'DSEX','DSES' => 'DSES',  'DS30' => 'DS30'] as $key => $value)
                                <div class="checkbox-inline">
                                    <label>
                                        {!! Form::checkbox('index[]', $key, in_array($key, isset($item->index) ? $item->index : [1])) !!} {{ $value }}
                                    </label>
                                </div>
                            @endforeach
                            {!! $errors->first('index', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>


                <!-- <div class="row">
                        <div class="col-md-2 text-right">
                        {!! Form::label('batch_id', 'Batch Id') !!}
                        </div>
                            <div class="col-lg-5">
                                <div class="form-group">

                                    {!! Form::number('batch_id', null, ['class' => 'form-control']) !!}
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

                                    {!! Form::number('market_id', null, ['class' => 'form-control']) !!}
                                    {!! $errors->first('market_id', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                            </div>

                        </div> -->

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
