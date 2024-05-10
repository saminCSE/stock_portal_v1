@extends('layouts.master')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <div class="card">
        <div class="card-body">
            @if (isset($item))
                {!! Form::model($item, [
                    'route' => ['review.update', $item->id],
                    'method' => 'PUT',
                    'class' => 'custom-validation',
                    'files' => true,
                    'role' => 'form',
                    'id' => 'edit-form',
                ]) !!}
            @else
                {!! Form::open([
                    'route' => ['review.store'],
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
                        {!! Form::label('user_name', 'User Name') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('user_name', isset($item->user_name) ? $item->user_name : null, [
                                'class' => 'form-control',
                                'placeholder' => 'User Name',
                            ]) !!}
                            {!! $errors->first('user_name', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('star', 'Star') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <select name="star" class="form-control">
                                @if(isset($item->star))
                                <option value="{{$item->star}}">{{$item->star}}</option>
                                @endif
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                            {!! $errors->first('star', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('review', 'Comment') !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::textarea('review', isset($item->review) ? $item->review : null, [
                                'class' => 'form-control',
                                'placeholder' => 'Write a Comment',
                                'rows' => 5 // You can adjust the number of rows as needed
                            ]) !!}
                            {!! $errors->first('review', '<p class="help-block text-danger">:message</p>') !!}
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
    <!-- <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script> -->
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>


    <script>
        $(function() {
            $('.datepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd',
            });
        });

        function generateSlug() {
            var title = document.getElementById("title").value;
            var slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').substr(0, 50);

            document.getElementById("slug").value = slug;
        }
    </script>
@endsection
