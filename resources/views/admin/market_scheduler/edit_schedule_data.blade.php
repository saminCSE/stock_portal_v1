@extends('layouts.master')
@section('content')
    @if (session('status'))
    <div class="alert alert-success">{{ session('status')}}</div>
    @endif
    <div class="card">
        <div class="card-body">
        @if(isset($item))
            {!! Form::model($item, ['route'=>["ChangeMarketSchedulerdata_update", $item->id],'method' =>'PUT', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
            @endif
            <form class="custom-validation" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                <div class="col-md-3 text-right">
                    {!! Form::label('open_date', 'Open Date') !!} 
                </div>
                    <div class="col-md-5">
                    <div class="form-group">
                      {!! Form::text('open_date',isset($item->open_date) ? $item->open_date : NULL,['class'=>'form-control datepicker', 'placeholder'=>'From Date','required'=>'required','disabled' => 'disabled']) !!}
                      {!! $errors->first('open_date', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                    </div>
                </div>
                <div class="row">
               <div class="col-md-3 text-right">
                {!! Form::label('open_time', 'Open Time') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                          {!! Form::text('open_time',isset($item->open_time) ? $item->open_time : NULL,['class'=>'form-control','disabled' => 'disabled'])!!}
                            {!! $errors->first('open_time','<p class="help-block text-danger">:message</p>') !!}
                        </div>
                        </div>
                </div>
                <div class="row">
                <div class="col-md-3 text-right">
                {!! Form::label('close_time', 'Close Time') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('close_time',isset($item->close_time) ? $item->close_time : NULL,['class'=>'form-control','disabled' => 'disabled']) !!}
                            {!! $errors->first('close_time','<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                <div class="col-md-3 text-right">
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
                <div class="col-md-3 text-right">
                {!! Form::label('comments', 'Comments') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('comments',isset($item->comments) ? $item->comments : NULL,['class'=>'form-control']) !!}
                            {!! $errors->first('comments', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5 text-right">
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" onclick="return confirm('Are You sure To Change Schedule');">
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
