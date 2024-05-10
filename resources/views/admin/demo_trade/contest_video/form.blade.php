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
        <h2>Create Contest Video</h2>
    </div>
    <div class="card">
        <div class="card-body">
            @if(isset($item))
                {!! Form::model($item,['route'=>["contest_video.update", $item->id],'method' =>'PUT', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
            @else
                {!! Form::open(['route' => ["contest_video.store"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
            @endif
            <form class="custom-validation" action="#">
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('contests_id', 'Contest') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::select('contests_id', $contest,isset($item->contests_id)?$item->contests_id: '',['class'=>'form-control']) !!}

                            {!! $errors->first('contests_id', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('video_one', 'Video One Link') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::textarea('video_one',isset($item->video_one)?$item->video_one:'',['class'=>'form-control']) !!}
                            {!! $errors->first('video_one', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('video_two', 'Video Two Link') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::textarea('video_two',isset($item->video_two)?$item->video_two:'',['class'=>'form-control']) !!}
                            {!! $errors->first('video_two', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('video_three', 'Video Three Link') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::textarea('video_three',isset($item->video_three)?$item->video_three:'',['class'=>'form-control']) !!}
                            {!! $errors->first('video_three', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('is_active', 'Status') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::select('is_active', $is_active,isset($item->is_active)?$item->is_active:'1',['class'=>'form-control']) !!}

                            {!! $errors->first('is_active', '<p class="help-block text-danger">:message</p>') !!}
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

    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>

    <script>
        $(function () {
            $('.datepicker').datepicker({
                autoclose:true,
                todayHighlight:true,
                format:'yyyy-mm-dd',
            });
    </script>




@endsection
