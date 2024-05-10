@extends('layouts.master')
@section('css')
    <!-- Summernote css -->
    <link href="{{ URL::asset('assets/libs/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css') }}" />
    <!-- datatables css -->
    <!-- <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/> -->
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css" />
    <style>
        table,
        td,
        th {
            vertical-align: middle !important;
        }

        table th {
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <h2>Create Contest</h2>
    </div>
    <div class="card">
        <div class="card-body">
            @if (isset($item))
                {!! Form::model($item, [
                    'route' => ['contest.update', $item->id],
                    'method' => 'put',
                    'class' => 'custom-validation',
                    'files' => true,
                    'role' => 'form',
                    'id' => 'edit-form',
                ]) !!}
            @else
                {!! Form::open([
                    'route' => ['contest.store'],
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
                        {!! Form::label('title', 'Title') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::text('title', isset($item->title) ? $item->title : '', ['class' => 'form-control']) !!}
                            {!! $errors->first('title', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('title_bn', 'Title (Bangla)') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::text('title_bn', isset($item->title_bn) ? $item->title_bn : '', ['class' => 'form-control']) !!}
                            {!! $errors->first('title_bn', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>


                <!-- Slug field -->
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('slug', 'Slug') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::text('slug', isset($item->slug) ? $item->slug : '', ['id' => 'slug', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('contest_type_id', 'Contest Type') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::select('contest_type_id', $contestType, isset($item->contest_type_id) ? $item->contest_type_id : '', [
                                'class' => 'form-control',
                            ]) !!}
                            {!! $errors->first('contest_type_id', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('short_description', 'Short Description') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::textarea('short_description', isset($item->short_description) ? $item->short_description : '', [
                                'class' => 'form-control',
                            ]) !!}
                            {!! $errors->first('short_description', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('short_description_bn', 'Short Description (Bangla)') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::textarea('short_description_bn', isset($item->short_description_bn) ? $item->short_description_bn : '', [
                                'class' => 'form-control',
                            ]) !!}
                            {!! $errors->first('short_description_bn', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('amount', 'Amount') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::text('amount', isset($item->amount) ? $item->amount : '', ['class' => 'form-control']) !!}
                            {!! $errors->first('amount', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('duration', 'Duration') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::text('duration', isset($item->duration) ? $item->duration : '', ['class' => 'form-control']) !!}
                            {!! $errors->first('duration', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('contest_start_date', 'Contest Start Date') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::text('contest_start_date', isset($item->contest_start_date) ? $item->contest_start_date : '', [
                                'class' => 'form-control datepicker',
                            ]) !!}
                            {!! $errors->first('contest_start_date', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('contest_end_date', 'Contest End Date') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::text('contest_end_date', isset($item->contest_end_date) ? $item->contest_end_date : '', [
                                'class' => 'form-control datepicker',
                            ]) !!}
                            {!! $errors->first('contest_end_date', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('registration_start_date', 'Registration Start Date') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::text(
                                'registration_start_date',
                                isset($item->registration_start_date) ? $item->registration_start_date : '',
                                ['class' => 'form-control datepicker'],
                            ) !!}
                            {!! $errors->first('registration_start_date', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('registration_end_date', 'Registration End date') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::text(
                                'registration_end_date',
                                isset($item->registration_end_date) ? $item->registration_end_date : '',
                                ['class' => 'form-control datepicker'],
                            ) !!}
                            {!! $errors->first('registration_end_date', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('number_of_participation', 'Number Of Participation') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::text(
                                'number_of_participation',
                                isset($item->number_of_participation) ? $item->number_of_participation : '',
                                ['class' => 'form-control'],
                            ) !!}
                            {!! $errors->first('number_of_participation', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                {{-- <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('contest_status', 'Contest Status') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::select('contest_status', $contestStatus, isset($item->contest_status) ? $item->contest_status : '', [
                                'class' => 'form-control',
                            ]) !!}
                            {!! $errors->first('contest_status', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div> --}}

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('contest_status_open', 'Contest Status Open') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::textarea('contest_status_open', isset($item->contest_status_open) ? $item->contest_status_open : '', [
                                'class' => 'form-control',
                            ]) !!}
                            {!! $errors->first('contest_status_open', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('contest_status_open_bn', 'Contest Status Open (Bangla)') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::textarea('contest_status_open_bn', isset($item->contest_status_open_bn) ? $item->contest_status_open_bn : '', [
                                'class' => 'form-control',
                            ]) !!}
                            {!! $errors->first('contest_status_open_bn', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('contest_status_close', 'Contest Status Close') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::textarea('contest_status_close', isset($item->contest_status_close) ? $item->contest_status_close : '', [
                                'class' => 'form-control',
                            ]) !!}
                            {!! $errors->first('contest_status_close', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('contest_status_close_bn', 'Contest Status Close (Bangla)') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::textarea('contest_status_close_bn', isset($item->contest_status_close_bn) ? $item->contest_status_close_bn : '', [
                                'class' => 'form-control',
                            ]) !!}
                            {!! $errors->first('contest_status_close_bn', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('is_active', 'Status') !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::select('is_active', $is_active, isset($item->is_active) ? $item->is_active : '', [
                                'class' => 'form-control',
                            ]) !!}

                            {!! $errors->first('is_active', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('long_description', 'Long Description') !!}
                    </div>
                    <div class="col-lg-10">
                        <div class="form-group">
                            {!! Form::textarea('long_description', isset($item->long_description) ? $item->long_description : '', [
                                'class' => 'form-control summernote',
                            ]) !!}
                            {!! $errors->first('long_description', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('long_description_bn', 'Long Description (Bangla)') !!}
                    </div>
                    <div class="col-lg-10">
                        <div class="form-group">
                            {!! Form::textarea('long_description_bn', isset($item->long_description_bn) ? $item->long_description_bn : '', [
                                'class' => 'form-control summernote',
                            ]) !!}
                            {!! $errors->first('long_description_bn', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('terms_and_conditions', 'Terms And Conditions') !!}
                    </div>
                    <div class="col-lg-10">
                        <div class="form-group">
                            {!! Form::textarea(
                                'terms_and_conditions',
                                isset($item->terms_and_conditions) ? $item->terms_and_conditions : '',
                                [
                                    'class' => 'form-control summernote',
                                ],
                            ) !!}
                            {!! $errors->first('terms_and_conditions', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('terms_and_condition_bn', 'Terms And Conditions (Bangla)') !!}
                    </div>
                    <div class="col-lg-10">
                        <div class="form-group">
                            {!! Form::textarea(
                                'terms_and_condition_bn',
                                isset($item->terms_and_condition_bn) ? $item->terms_and_condition_bn : '',
                                [
                                    'class' => 'form-control summernote',
                                ],
                            ) !!}
                            {!! $errors->first('terms_and_condition_bn', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('who_can_register', 'Who Can Register') !!}
                    </div>
                    <div class="col-lg-10">
                        <div class="form-group">
                            {!! Form::textarea('who_can_register', isset($item->who_can_register) ? $item->who_can_register : '', [
                                'class' => 'form-control summernote',
                                'style' => 'height: 300px;',
                            ]) !!}
                            {!! $errors->first('who_can_register', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        {!! Form::label('who_can_register_bn', 'Who Can Register (Bangla)') !!}
                    </div>
                    <div class="col-lg-10">
                        <div class="form-group">
                            {!! Form::textarea('who_can_register_bn', isset($item->who_can_register_bn) ? $item->who_can_register_bn : '', [
                                'class' => 'form-control summernote',
                                'style' => 'height: 300px;',
                            ]) !!}
                            {!! $errors->first('who_can_register_bn', '<p class="help-block text-danger">:message</p>') !!}
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
    <!-- Summernote js -->
    <script src="{{ URL::asset('assets/libs/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $(function() {

            $('.summernote').summernote();

            $('.datepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd',
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to generate slug from title
            function generateSlug(title) {
                return title.trim().toLowerCase().replace(/[^a-z0-9\s]/g, '').replace(/\s+/g, '-');
            }

            // Event listener for title input
            $('#title').on('input', function() {
                var title = $(this).val();
                var slug = generateSlug(title);

                // Update the value of the slug field
                $('#slug').val(slug);
            });
        });
    </script>
@endsection
