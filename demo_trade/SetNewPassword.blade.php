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

                            <form method="POST" action="{{ route('demo.forgot_password_reset_submit') }}">
                                @csrf
                                <input type="hidden" value="{{ $verificationCode }}" name="key">

                                <div class="row my-3 align-items-center">
                                    <div class="col-md-3">
                                        <label for="password" class="form-label">{{ __('txt.new_password') }} :</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="mb-3 text-center">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row my-3 align-items-center">
                                    <div class="col-md-3">
                                        <label for="password_confirmation"
                                            class="form-label">{{ __('txt.confirm_new_password') }} :</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="mb-3 text-center">
                                            <input id="password_confirmation" type="password"
                                                class="form-control" name="password_confirmation" required>
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
