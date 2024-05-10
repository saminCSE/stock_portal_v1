@extends('layouts.demo_master')
@section('content')
    <div style="height: 200px" class="demo_section main-slider">
        <div style="height: 200px" class="container main-slider__container">
            <div class="main-slider__bg bg">

                <div class="bg__item bg__item_gradient"></div>
            </div>
            <div style="height: 200px" class="content main-slider__content">
                <div style="min-height: 200px;padding:0;transform: translateY(60px);" class="main-slider__in">
                    <h3 style="margin-bottom: 0px;" class="" style=""></h3>
                    <div class="main-slider__desc">

                    </div>

                </div>
            </div>
        </div>
    </div>





    <div class="main_panel">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header h3 text-center">{{ __('txt.forgot_password') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('demo.forgot_password_reset') }}">
                                @csrf

                                <div class="row my-3 align-items-center">
                                    <div class="col-md-3">
                                        <label for="email" class="form-label">{{ __('txt.email_address') }} :</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="text-center">

                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" required autofocus>
                                            @if (session('error'))
                                                <div class="text-danger">
                                                    {{ session('error') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="text-center">
                                    <button type="submit" class="enroll-btn"
                                        style="width: 300px">{{ __('txt.send_reset_link') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
