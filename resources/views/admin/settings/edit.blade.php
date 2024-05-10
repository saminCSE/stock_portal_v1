@extends('layouts.master')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <div class="card">
        <div class="card-body">
            <h3 class="text-center mb-3">Settings</h3>
            <div class="row">
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>{{ session()->get('message') }}</strong>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        @if (is_array(session()->get('error')))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach (session()->get('error') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <strong>{{ session()->get('error') }}</strong>
                        @endif
                    </div>
                @endif
                {{-- {{dd($errors)}} --}}
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="js-message-wrap">

                </div>
                <div class="col-md-8 offset-md-2">
                    {!! Form::model($item, [
                        'route' => ['settings.update'],
                        'method' => 'POST',
                        'class' => 'custom-validation',
                        'files' => true,
                        'role' => 'form',
                        'id' => 'edit-form',
                    ]) !!}

                    <form class="custom-validation" action="#">
                        @csrf

                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('brand_name', 'Brand Name') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::text('brand_name', $item->brand_name, [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('address', 'Address') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::text('address', $item->address, [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('phone', 'Phone') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::text('phone', $item->phone, [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('email', 'Email') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::email('email', $item->email, [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('mail_to', 'Mail To') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::email('mail_to', $item->mail_to, [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('logo', 'Logo') !!}
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    {!! Form::file('logo', [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <img src="{{ asset($item->logo) }}" alt="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('favicon', 'Favicon') !!}
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    {!! Form::file('favicon', [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <img src="{{ asset($item->favicon) }}" alt="">
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('fb_link', 'Facebook Link') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::text('fb_link', $item->fb_link, [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('twitter_link', 'Twitter Link') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::text('twitter_link', $item->twitter_link, [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('youtube_link', 'Youtube Link') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::text('youtube_link', $item->youtube_link, [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('instagram_link', 'Intstragram Link') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::text('instagram_link', $item->instagram_link, [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('service_day', 'Service Day') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::text('service_day', $item->service_day, [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('service_time', 'Service Time') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::text('service_time', $item->service_time, [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('term_and_condition', 'Terms and Condition') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::textarea('term_and_condition', $item->term_and_condition, [
                                        'class' => 'form-control summernote',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('term_and_condition_bn', 'Terms and Condition (Bangla)') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::textarea('term_and_condition_bn', $item->term_and_condition_bn, [
                                        'class' => 'form-control summernote',
                                    ]) !!}
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('term_and_condition', 'User Manual') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::textarea('user_manual', $item->user_manual, [
                                        'class' => 'form-control summernote',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('demo_banner_heading', 'Demo Banner Heading') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::textarea('demo_banner_heading', $item->demo_banner_heading, [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('demo_banner_heading_bn', 'Demo Banner Heading (Bangla)') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::textarea('demo_banner_heading_bn', $item->demo_banner_heading_bn, [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('demo_banner_desc', 'Demo Banner Description') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::textarea('demo_banner_desc', $item->demo_banner_desc, [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-left">
                                {!! Form::label('demo_banner_desc_bn', 'Demo Banner Description (Bangla)') !!}
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    {!! Form::textarea('demo_banner_desc_bn', $item->demo_banner_desc_bn, [
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-center">
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
            </div>


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
    <script src="{{ URL::asset('assets/libs/summernote/summernote-bs4.min.js') }}"></script>


    <script>
        $(function() {
            $('.summernote').summernote();


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
