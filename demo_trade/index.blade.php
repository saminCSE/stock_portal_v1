@extends('layouts.demo_master')
@section('content')
    <main>
        <div style="height: 135px" class="demo_section main-slider">
            <div style="height: 135px" class="container main-slider__container">
                <div class="main-slider__bg bg">
                    {{-- <picture class="bg__item bg__item_candles">
                        <img src="{{ URL::asset('assets/images/header-bg-1.png') }}" alt="">
                    </picture> --}}
                    {{-- <picture class="bg__item bg__item_phone">
                        <img src="images/header-bg-2.png" alt="">
                    </picture>
                    <picture class="bg__item bg__item_note">
                        <source srcset="{{ URL::asset('assets/images/header-bg-3_1.png') }}" media="(max-width: 550px)"
                            type="image/jpeg">

                        <source srcset=" {{ URL::asset('assets/images/header-bg-3_2.png') }}" media="(max-width: 1024px)"
                            type="image/jpeg">

                        <img src=" {{ URL::asset('assets/images/header-bg-3.png') }}" alt="">
                    </picture> --}}
                    <div class="bg__item bg__item_gradient"></div>
                </div>
                <div style="height: 135px" class="content main-slider__content">
                    <div style="min-height: 135px;padding:0;transform: translateY(60px);" class="main-slider__in">
                        {{-- <h2 style="margin-bottom: 0px;" class="main-slider__title" style="">My Portfolio Contest</h2> --}}
                        <div class="main-slider__desc">
                            {{-- <p class="main-slider__desc_bold">An Opportunity to Learn, Invest and Win!</p> --}}
                            {{-- <p>An Opportunity to Learn, Invest and Win!</p> --}}
                        </div>
                        {{-- <div class="main-slider__btn-container">
                            <a target="_self" href="http://103.129.247.173/clients/"
                                class="waves btn btn-primary">{{ __('txt.banner_btn') }}</a>
                        </div>
                        <a target="_self" href="#conditions" class="main-slider__scroll-down ">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 34" text-rendering="geometricPrecision"
                                shape-rendering="geometricPrecision" style="white-space: pre;">
                                <rect width="18" height="32.3" fill="none" stroke="#ffffff" stroke-width="2"
                                    rx="9" transform="translate(11,17.85) translate(-10,-17)"></rect>
                                <path d="M0,0L0,6" stroke="#ffffff" fill="none" stroke-width="2" stroke-linecap="round"
                                    transform="translate(10,6)" style="animation: 3.8s linear infinite both a0_t;"></path>
                            </svg>
                            Browse
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>


        <div class="demo_banner">
            <div class="container">
                <div class="content-container">
                    <div class="demo-header-content">
                        <h2> {{ session('applocale') === 'bn' ? $settings->demo_banner_heading_bn : $settings->demo_banner_heading }}</h2>
                        <p>{{ session('applocale') === 'bn' ? $settings->demo_banner_desc_bn : $settings->demo_banner_desc }}</p>
                    </div>
                </div>
            </div>
        </div>




        <div class="demo_section challenge_section">
            <div style="padding: 20px 0" class="container">
                <div class="row">
                    <div class="col-lg-8">

                        @if (session('message'))
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <div>{{ session('message') }}</div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <div>{{ session('error') }}</div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- <div class="row">

                            <div class="col-md-6">
                                @auth
                                    @if ($is_enrolled)
                                        <a href="{{ route('demo.contest.panel', env('Free_demo_slug', 'free-demo')) }}">
                                        @else
                                            <a data-bs-toggle="modal" data-bs-target="#free-demo-enroll-modal">
                                    @endif
                                @else
                                    <a data-bs-toggle="modal" data-bs-target="#loginmodal">
                                    @endauth

                                    <div class="card">
                                        <div class="card-header">Header</div>
                                        <div class="card-body">
                                            <h4 class="card-title">Free Demo</h4>
                                            <p class="card-text">Text</p>
                                        </div>
                                        <div class="card-footer text-muted">Footer</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('demo.demo-contest') }}">
                                    <div class="card">
                                        <div class="card-header">Header</div>
                                        <div class="card-body">
                                            <h4 class="card-title">Demo Contest</h4>
                                            <p class="card-text">Text</p>
                                        </div>
                                        <div class="card-footer text-muted">Footer</div>
                                    </div>
                                </a>
                            </div>



                        </div> --}}


                        <div class="row mt-5">

                            {{-- <div class="col-md-6 text-center p-3 wow animate__fadeIn" data-wow-duration="3s">
                                <div>
                                    @auth
                                        @if ($is_enrolled)
                                            <a class="enroll-btn" style="color:white !important; font-size:20px"
                                                href="{{ route('demo.contest.panel', env('Free_demo_slug', 'free-demo')) }}">
                                            @else
                                                <a class="enroll-btn" style="color:white !important; font-size:20px"
                                                    data-bs-toggle="modal" data-bs-target="#free-demo-enroll-modal">
                                        @endif
                                    @else
                                        <a class="enroll-btn" style="color:white !important; font-size:20px"
                                            data-bs-toggle="modal" data-bs-target="#loginmodal">
                                        @endauth
                                        {{ __('txt.free_demo') }} </a>
                                </div>
                                <p class="mt-2" style="max-width: 350px;margin:auto;text-align:justify">
                                    {{ __('txt.about_free_demo') }}
                                </p>
                            </div>
                            <div class="col-md-6 text-center p-3 wow animate__fadeIn" data-wow-duration="3s">
                                <a class="enroll-btn" style="color:white !important; font-size:20px"
                                    href="{{ route('demo.demo-contest') }}">{{ __('txt.contest') }}</a>

                                <p class="mt-2" style="max-width: 350px;margin:auto;text-align:justify">
                                    {{ __('txt.about_contest') }}</p>
                            </div> --}}

                            <div class="col-md-12 mb-4 wow animate__fadeIn" data-wow-duration="3s">
                                <div class="card text-left">
                                    <div class="card-body row align-items-center">
                                        <div class="col-md-3 text-center">
                                            @auth
                                                @if ($is_enrolled)
                                                    <a class="enroll-btn" style="color:white !important; font-size:20px"
                                                        href="{{ route('demo.contest.panel', env('Free_demo_slug', 'free-demo')) }}">
                                                    @else
                                                        <a class="enroll-btn" style="color:white !important; font-size:20px"
                                                            data-bs-toggle="modal" data-bs-target="#free-demo-enroll-modal">
                                                @endif
                                            @else
                                                <a class="enroll-btn" style="color:white !important; font-size:20px"
                                                    data-bs-toggle="modal" data-bs-target="#loginmodal">
                                                @endauth
                                                {{ __('txt.free_demo') }}
                                            </a>
                                        </div>
                                        <div class="col-md-9">
                                            <p style="text-align: justify">{{ __('txt.about_free_demo') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4 wow animate__fadeIn" data-wow-duration="3s">
                                <div class="card text-left">
                                    <div class="card-body row align-items-center">
                                        <div class="col-md-3 text-center">
                                            <a class="enroll-btn" style="color:white !important; font-size:20px"
                                                href="{{ route('demo.demo-contest') }}">{{ __('txt.contest') }}</a>
                                        </div>
                                        <div class="col-md-9">
                                            <p style="text-align: justify"> {{ __('txt.about_contest') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>



                    </div>




                    <div class="col-lg-4 demo-sidebar">

                        @if (isset($video->video_one))
                            <div class="content-container mb-4 wow animate__fadeIn iframe" data-wow-duration="3s">
                                {!! $video->video_one !!}
                            </div>
                        @endif

                        @auth
                            {{-- <a class="mb-4"
                                style="display: block;background: #154879;border-radius: 10px;padding: 10px;text-align: center;color: white !important;"
                                href="{{ route('demo.user_dashboard') }}">Go To Dashboard</a> --}}
                        @else
                            @include('layouts.demo_signup')
                        @endauth






                        @if (isset($video->video_two))
                            <div class="content-container mb-4 wow animate__fadeIn iframe" data-wow-duration="3s">
                                {!! $video->video_two !!}
                            </div>
                        @endif
                        @if (isset($video->video_three))
                            <div class="content-container mb-4 wow animate__fadeIn iframe" data-wow-duration="3s">
                                {!! $video->video_three !!}
                            </div>
                        @endif
                        {{-- <div class="content-container mb-4 wow animate__fadeIn" data-wow-duration="3s">
                            <h3>Terms And Conditions</h3>
                            <img width="100%" src="{{ URL::asset('uploads/demo/image/demo.png') }}" alt=""
                                class="pdf-viewer" data-pdf-path="{{ URL::asset('uploads/demo/pdf/demo.pdf') }}">
                            <div class="text-center mt-3" class="button"><span
                                    style="background: #003b72;font-weight:600" class="btn btn-primary pdf-viewer"
                                    data-pdf-path="{{ URL::asset('uploads/demo/pdf/demo.pdf') }}">Read More</span></div>
                        </div>
                    </div> --}}
                    </div>
                </div>
            </div>



            {{-- <div class="modal fade" id="free-demo-enroll-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">

                        <div class="modal-body" style="min-height: 400px;">
                            <form action="{{ route('demo.user.enroll', env('Free_demo_slug', 'free-demo')) }}">
                                @csrf

                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3>Do you want to create your demo portfolio ?</h3>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <button type="submit" class="enroll-btn m-2">Yes</button>
                                        <button style="" type="button" class="text-white enroll-btn m-2"
                                            data-bs-dismiss="modal" aria-label="Close">No</button>
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div> --}}





            <div class="modal fade" id="free-demo-enroll-modal" data-bs-backdrop="static" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button> --}}
                        </div>
                        <form class="create_portfolio_form" action="{{ route('demo.user.enroll', env('Free_demo_slug', 'free-demo')) }}">
                            @csrf
                            <div class="modal-body">

                                <h3 class="text-center mb-4">{{ __('txt.createVirtualPortfolio') }}</h3>


                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="brokerHouse" class="form-label">{{ __('txt.brokerHouse') }}</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="brokerHouse" name="brokerHouse"
                                            placeholder="{{ __('txt.brokerHouse') }}"
                                            value="{{ old('brokerHouse') ? old('brokerHouse') : 'Sheba Capital Limited' }}">

                                        @error('brokerHouse')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="branchName" class="form-label">{{ __('txt.branchName') }}</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="branchName" name="branchName"
                                            placeholder="{{ __('txt.branchName') }}"
                                            value="{{ old('branchName') ? old('branchName') : 'Motijheel' }}">

                                        @error('branchName')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="portfolioName"
                                            class="form-label">{{ __('txt.portfolioName') }}</label>
                                    </div>

                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="portfolioName"
                                            name="portfolioName" placeholder="{{ __('txt.portfolioName') }}"
                                            value="{{ (old('portfolioName') ? old('portfolioName') : Auth::user()) ? Auth::user()->full_name : '' }}">

                                        @error('portfolioName')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="commissionRate"
                                            class="form-label">{{ __('txt.commissionRate') }}</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="commissionRate"
                                            name="commissionRate" placeholder="{{ __('txt.commissionRate') }}"
                                            value="{{ old('commissionRate') ? old('commissionRate') : $comission }}">

                                        @error('commissionRate')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="depositAmount"
                                            class="form-label">{{ __('txt.depositAmount') }}</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="depositAmount"
                                            name="depositAmount" placeholder="{{ __('txt.depositAmount') }}"
                                            value="{{ old('depositAmount') ? old('depositAmount') : $deposit_amount }}">

                                        @error('depositAmount')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer justify-content-center">

                                <input type="submit" class="enroll-btn me-4" value="{{ __('txt.submit') }}"
                                    style="font-weight:400">

                                <button type="button" class="enroll-btn"
                                    data-bs-dismiss="modal">{{ __('txt.cancel') }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

    </main>

    <script>
        @if (session('portfolioerror'))
            $(document).ready(function() {
                $('#free-demo-enroll-modal').modal('show');
            });
        @endif
    </script>

    <script>
        $(document).ready(function() {
            // Add validation rules for your form fields
            $(".create_portfolio_form").validate({
                onkeyup: function(element) {
                    $(element).valid();
                },
                rules: {
                    brokerHouse: "required",
                    branchName: "required",
                    portfolioName: "required",
                    commissionRate: {
                        required: true,
                        number: true,
                        range: [0, 100] // Ensure commissionRate is between 0 and 100
                    },
                    depositAmount: {
                        required: true,
                        number: true,
                    }
                },
                messages: {
                    brokerHouse: "Please enter the broker house name",
                    branchName: "Please enter the branch name",
                    portfolioName: "Please enter the portfolio name",
                    commissionRate: {
                        required: "Please enter the commission rate",
                        number: "Please enter a valid number for commission rate",
                        range: "Please enter a number between 0 and 100 for commission rate"
                    },
                    depositAmount: {
                        required: "Please enter the deposit amount",
                        number: "Please enter a valid number for deposit amount",
                    }
                },
                submitHandler: function(form) {
                    // Handle the form submission (e.g., AJAX request or regular form submit)
                    form.submit();
                }
            });
        });
    </script>
@endsection
