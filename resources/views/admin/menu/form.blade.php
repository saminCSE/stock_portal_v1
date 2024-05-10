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
                {!! Form::model($item, ['route' => ["menu.update", $item->id],'method' =>'PUT', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
            @else
                {!! Form::open(['route' => ["menu.store"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
            @endif
            <form class="custom-validation" action="#">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('menu_name', ' Name') !!} <span class="la-required">*</span>
                            {!! Form::text('menu_name', null,['class'=>'form-control', 'placeholder'=>'Name']) !!}
                            {!! $errors->first('menu_name', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug') !!} 
                            {!! Form::text('slug', null,['class'=>'form-control', 'placeholder'=>'Link']) !!}
                            {!! $errors->first('slug', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('parent_id', 'Parent Menu') !!} 
                            {!! Form::select('parent_id', $parent_menu, isset($item->parent_id) ? $item->parent_id : NULL, ['class' => 'form-control']) !!}
                            {!! $errors->first('parent_id', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('is_active', 'Status') !!} 
                            {!! Form::select('is_active', $isActivestatus, isset($item->is_active) ? $item->is_active : 1, ['class' => 'form-control']) !!}
                            {!! $errors->first('is_active', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('orderno', 'Order No') !!} 
                            {!! Form::text('orderno', null,['class'=>'form-control', 'placeholder'=>'Order No']) !!}
                            {!! $errors->first('orderno', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('project_no', 'Project No') !!} 
                            {!! Form::select('project_no', ['1'=>'Laravel','2'=>'Codeigniter'], isset($item->project_no) ? $item->project_no : 1, ['class' => 'form-control']) !!}
                            {!! $errors->first('project_no', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('icon_id', 'Icon') !!} 
                            {!! Form::text('icon_id', null,['class'=>'form-control', 'placeholder'=>'Icon']) !!}
                            {!! $errors->first('icon_id', '<p class="help-block text-danger">:message</p>') !!}
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
                                <a href={{route('menu.index')}}>
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