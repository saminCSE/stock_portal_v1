@extends('layouts.demo_master')
@section('content')
    <main>

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
            <div class="container">
                <div class="demo-nav row">
                    <div class="left col-md-6">
                        <h4 class=" wow animate__fadeIn" data-wow-duration="3s">{{ __('txt.my_profile') }}</h4>
                    </div>
                    <div class="right col-md-6 text-end">
                        <a href="{{ route('demo.user_dashboard') }}"
                            class="btn btn-primary-outline log_out wow animate__fadeIn"
                            data-wow-duration="3s">{{ __('txt.dashboard') }}</a>
                    </div>
                </div>

                <div class="mt-4">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs wow animate__fadeIn" data-wow-duration="3s" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-details-tab" data-bs-toggle="tab"
                                data-bs-target="#profile-details" type="button" role="tab"
                                aria-controls="profile-details" aria-selected="true">
                                {{ __('txt.profile_details') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="edit-profile-tab" data-bs-toggle="tab"
                                data-bs-target="#edit-profile" type="button" role="tab" aria-controls="edit-profile"
                                aria-selected="false">
                                {{ __('txt.update_profile') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="change-password-tab" data-bs-toggle="tab"
                                data-bs-target="#change-password" type="button" role="tab"
                                aria-controls="change-password" aria-selected="false">
                                {{ __('txt.change_password') }}
                            </button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content my-3" style="border:1px solid #ddd; padding:20px;">
                        <div class="tab-pane active" id="profile-details" role="tabpanel"
                            aria-labelledby="profile-details-tab">
                            <h4>{{ __('txt.profile_details') }}</h4>
                            <hr>
                            @if (session('message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <table class="table wow animate__fadeIn" data-wow-duration="3s">
                                <tr>
                                    <th>{{ __('txt.full_name') }} :</th>
                                    <td>{{ Auth::user()->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('txt.email') }} :</th>
                                    <td>
                                        {{ Auth::user()->email }}
                                        @if (Auth::user()->is_email_verified == 0)
                                            <p class="badge bg-danger" style="margin: 0">{{ __('txt.not_verified') }}</p>
                                            <a href="{{ route('demo.email.verify.send') }}" class="badge bg-primary"
                                                style="text-decoration: none;">{{ __('txt.verify_now') }}</a>
                                        @else
                                            <p class="badge bg-success" style="margin: 0">{{ __('txt.verified') }}</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('txt.mobile') }} :</th>
                                    <td>
                                        {{ Auth::user()->mobile }}
                                        @if (Auth::user()->is_phone_verified == 0)
                                            <p class="badge bg-danger" style="margin: 0">{{ __('txt.not_verified') }}</p>
                                            <a href="javascript:void(0);" class="badge bg-primary" id="btn_verify"
                                                style="text-decoration: none;">{{ __('txt.verify_now') }}</a>
                                        @else
                                            <p class="badge bg-success" style="margin: 0">{{ __('txt.verified') }}</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('txt.gender') }} :</th>
                                    <td>{{ Auth::user()->gender }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('txt.nid') }} :</th>
                                    <td>{{ Auth::user()->nid ? Auth::user()->nid : null }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('txt.organization') }} :</th>
                                    <td>{{ Auth::user()->organization ? Auth::user()->organization : null }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="tab-pane" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
                            <h4>{{ __('txt.update_profile_info') }}</h4>
                            <hr>
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form class="signup_validator wow animate__fadeIn" data-wow-duration="3s" action="{{ route('demo.update.profile') }}" method="post">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label for="name" class="form-label">{{ __('txt.name') }} <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="{{ Auth::user()->full_name }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label for="email" class="form-label">{{ __('txt.email') }} <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="email" name="email" class="form-control" id="email"
                                            value="{{ Auth::user()->email }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label for="mobile" class="form-label">{{ __('txt.phone') }} <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="mobile" class="form-control" id="mobile"
                                            value="{{ Auth::user()->mobile }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label for="nid" class="form-label">{{ __('txt.nid') }}</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="nid" class="form-control" id="nid"
                                            value="{{ Auth::user()->nid ? Auth::user()->nid : '' }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label for="organization" class="form-label">{{ __('txt.organization') }}</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="organization" class="form-control" id="organization"
                                            value="{{ Auth::user()->organization ? Auth::user()->organization : '' }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label for="gender" class="form-label">{{ __('txt.gender') }} <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-10">
                                        <select class="form-select" name="gender" id="gender"
                                            aria-label="Select Gender">
                                            <option value="" {{ Auth::user()->gender === '' ? 'selected' : '' }}>
                                                {{ __('txt.select_gender') }}
                                            </option>
                                            <option value="Male"
                                                {{ Auth::user()->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female"
                                                {{ Auth::user()->gender === 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value="Others"
                                                {{ Auth::user()->gender === 'Others' ? 'selected' : '' }}>Others</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label for="contest_user_type_id"
                                            class="form-label">{{ __('txt.contest_user_type') }} <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-10">
                                        <select class="form-select" name="contest_user_type_id" id="contest_user_type_id"
                                            aria-label="Select Contest User Type">
                                            <option>{{ __('txt.select_one') }}</option>
                                            @foreach ($contestUserTypes as $id => $title)
                                                <option value="{{ $id }}"
                                                    {{ Auth::user()->contest_user_type_id == $id ? 'selected' : '' }}>
                                                    {{ $title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2">
                                        <input type="Submit"
                                            class="form-control bg-success text-white signup-submit-btnF"
                                            style="background-color:#154879 !important" id="signup_submit"
                                            value="{{ __('txt.update') }}">
                                    </div>
                                </div>

                            </form>
                        </div>

                        <div class="tab-pane" id="change-password" role="tabpanel"
                            aria-labelledby="change-password-tab">
                            <h4>{{ __('txt.change_password') }}</h4>
                            <hr>
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form class=" wow animate__fadeIn" data-wow-duration="3s" action="{{ route('demo.change.password') }}" method="POST">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label for="current_password" class="form-label">{{ __('txt.current_password') }}
                                            <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="password" name="current_password" class="form-control"
                                            id="current_password" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label for="new_password" class="form-label">{{ __('txt.new_password') }} <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="password" name="new_password" class="form-control"
                                            id="new_password" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label for="new_password_confirmation"
                                            class="form-label">{{ __('txt.confirm_new_password') }} <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="password" name="new_password_confirmation" class="form-control"
                                            id="new_password_confirmation" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2">
                                        <button type="submit"
                                            class="form-control bg-success text-white signup-submit-btn"
                                            style="background-color:#154879 !important" id="change_password_submit">
                                            {{ __('txt.change_password') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>


                </div>





            </div>



            <!-- Modal -->
            <div class="modal fade" data-bs-backdrop="static" id="phone_verify_modal" tabindex="-1" role="dialog"
                aria-labelledby="modalTitleId" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">{{ __('txt.otp_verification') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form id="phone_otp_form" action="{{ route('demo.phone.verify') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">{{ __('txt.otp') }}</label>
                                        </div>
                                        <div class="col-md-9 mb-3">
                                            <input type="text" class="form-control" id="exampleFormControlInput1"
                                                placeholder="{{ __('txt.enter_otp') }}" name="otp">
                                                <div id="errorMessage" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <p style="margin-bottom: 0;margin-right:10px" id="countdownTimer">{{ env('OTP_COUNTDOWN_TIME',60) }}
                                        {{ __('txt.seconds') }}</p>
                                    <a class="resend_otp" href="javascript:void(0);" id="resendOtpBtn"
                                        class="disabled">{{ __('txt.resend_otp') }}</a>
                                    <div id="loader" class="ms-2"></div>
                                </div>
                                <input type="submit" id="verifyBtn" class="enroll-btn"
                                    value="{{ __('txt.verify_now') }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>







            <script>
                $(document).ready(function() {

                    var countdown = {{ env('OTP_COUNTDOWN_TIME',60) }};
                    var countdownInterval;

                    function startCountdown() {
                        countdown = {{ env('OTP_COUNTDOWN_TIME',60) }};
                        updateCountdown();

                        countdownInterval = setInterval(function() {
                            if (countdown > 0) {
                                countdown--;
                                updateCountdown();
                            } else {
                                clearInterval(countdownInterval);
                                $('#resendOtpBtn').removeClass('disabled');
                            }
                        }, 1000);
                    }

                    function updateCountdown() {
                        $('#countdownTimer').text(countdown + ' seconds');
                    }

                    $('#resendOtpBtn').click(function() {
                        if (!$(this).hasClass('disabled')) {
                            resendOtp();
                        }
                    });
                    $('#btn_verify').click(function() {
                        resendOtp();
                    });



                    function resendOtp() {
                        // console.log('hi');
                        $('#phone_verify_modal').modal('show');
                        $('#loader').addClass('loader');
                        $.ajax({
                            url: "{{ route('demo.phone.verify.send') }}",
                            type: "GET",
                            success: function(response) {
                                if (response.success) {
                                    $('#loader').removeClass('loader');
                                    countdown = {{ env('OTP_COUNTDOWN_TIME',60) }};
                                    startCountdown();
                                    $('#resendOtpBtn').addClass('disabled');
                                }
                            },
                            error: function(error) {}
                        });
                    }


                    $('#phone_otp_form').submit(function(event) {
                        event.preventDefault(); // Prevent the default form submission

                        // Your AJAX call
                        $.ajax({
                            type: $(this).attr('method'), // Method (POST in this case)
                            url: $(this).attr('action'), // Form action URL
                            data: $(this).serialize(), // Serialize form data
                            success: function(response) {
                                if (response.success) {
                                    // Display success message
                                    window.location.reload();
                                    // You can redirect or perform any other action here
                                } else {
                                    // Display error message
                                    $('#errorMessage').text(response.error).show();
                                }
                                console.log(response);
                            },
                            error: function(error) {
                                // Handle the error response
                                console.log(error);
                            }
                        });
                    });


                });
            </script>

        </div>
    </main>
@endsection
