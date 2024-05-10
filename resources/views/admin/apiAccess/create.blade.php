@extends('layouts.master')

@section('css')
    <!-- datatables css -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <div class="card">
        <div class="box-header with-border col-6 text-right">
            <h3 class="box-title">Add User For Access The Api</h3>
        </div>
        <div class="card-body">
            @if (isset($item))
                {!! Form::model($item, [
                    'route' => ['api_access.update', $item->id],
                    'method' => 'PUT',
                    'enctype' => 'multipart/form-data',
                    'class' => 'custom-validation',
                    'files' => true,
                    'role' => 'form',
                    'id' => 'edit-form',
                ]) !!}
            @else
                {!! Form::open([
                    'route' => ['api_access.store'],
                    'method' => 'POST',
                    'enctype' => 'multipart/form-data',
                    'class' => 'custom-validation',
                    'files' => true,
                    'role' => 'form',
                    'id' => 'add-form',
                ]) !!}
            @endif
            <form class="custom-validation" action="#">
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('name', 'Company Name') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('username', 'User Name') !!}
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::text('username', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('username', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('password', 'Password') !!}
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::text('password', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('password', '<p class="help-block text-danger">:message</p>') !!}
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
