@extends('layouts.master')
@section('content')
    @if (session('status'))
    <div class="alert alert-success">{{ session('status')}}</div>
    @endif
    <div class="card">
        <div class="card-body">
        @if(isset($item))
            {!! Form::model($item, ['route'=>["book.update", $item->id],'method' =>'PUT', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
            @else
            {!! Form::open(['route' => ["book.store"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
            @endif
        <form class="custom-validation" action="#">


                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('title', 'Title') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('title', isset($item->title)?$item->title:null,['class'=>'form-control','placeholder'=>'Title',]) !!}
                            {!! $errors->first('title', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>



                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('description', 'Description') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::textarea('description', isset($item->description)?$item->description:null,['class'=>'form-control', 'placeholder'=>'Description']) !!}
                            {!! $errors->first('description', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                </div>
                </div>


                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('file', 'File') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::file('file', null,['class'=>'form-control']) !!}
                            {!! $errors->first('file', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                        <div>


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

    function generateSlug() {
    var title = document.getElementById("title").value;
    var slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').substr(0, 50);

    document.getElementById("slug").value = slug;
}
</script>
@endsection
