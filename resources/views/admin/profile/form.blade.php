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
                {!! Form::model($item, ['route' => ["categories.update", $item->id],'method' =>'PUT', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
            @else
                {!! Form::open(['route' => ["categories.store"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
            @endif
            <form class="custom-validation" action="#">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('category_id', 'Categories') !!}
                            <span class="la-required">*</span>
                            {!! Form::select('category_id', $categories, isset($category_ids) ? $category_ids : null, ['class' => 'form-control select2', 'id' => 'category']) !!}
                            {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('title', trans('messages.title')) !!} <span class="la-required">*</span>
                            {!! Form::text('title', null,['class'=>'form-control', 'placeholder'=>trans('messages.enter_title'), 'required'=>'required']) !!}
                            {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('is_published', trans('messages.is_published')) !!} <span
                                    class="la-required">*</span>
                            {!! Form::select('is_published', $published_status, isset($item->is_published) ? $item->is_published : 2, ['class' => 'form-control', 'required'=>'required']) !!}
                            {!! $errors->first('is_published', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('is_show_menu', 'Is Show Menu') !!} <span
                                    class="la-required">*</span>
                            {!! Form::select('is_show_menu', $is_show_menu, isset($item->is_show_menu) ? $item->is_show_menu : 2, ['class' => 'form-control', 'required'=>'required']) !!}
                            {!! $errors->first('is_show_menu', '<p class="help-block">:message</p>') !!}
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
                                <a href={{route('categories.index')}}>
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
        $(function () {
//multiple select
            $('#category').select2({
                placeholder: "Select Category"
            });
        });
    </script>
@endsection