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
                            <div class="alert alert-success mt-3">{{ session('message') }}</div>
                        @endif

                        <div class="row">
                            @if (count($contests) > 0)
                                @foreach ($contests as $contest)
                                    <div class="col-lg-12 contest mb-4 wow animate__fadeIn" data-wow-duration="3s">

                                        <div style="height: 100%;" class="card">
                                            <div class="card-header">
                                                <a href="{{ route('demo.contest_details', $contest->slug) }}">
                                                    <h3 style="font-size:20px">
                                                        {{ session('applocale') === 'bn' ? $contest->title_bn : $contest->title }}
                                                    </h3>
                                                </a>
                                                <h6>
                                                    @php
                                                        $short_description = session('applocale') === 'bn' ? $contest->short_description_bn : $contest->short_description;
                                                    @endphp
                                                    {{ mb_substr($short_description, 0, 200) }}
                                                    @if (strlen($short_description) > 200)
                                                        <span id="dots-{{ $contest->id }}">...</span>
                                                        <span id="more-{{ $contest->id }}"
                                                            style="display: none;">{{ substr($short_description, 200) }}</span>
                                                        <a href="{{ route('demo.contest_details', $contest->slug) }}"
                                                            style="color: rgb(96, 139, 218)!important; text-decoration: underline">{{ __('txt.read_more') }}</a>
                                                    @endif
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6" style="border-right: 1px solid gray">
                                                        <h4
                                                            style="font-size:20px ;padding-bottom: 0;display: inline-block;border-bottom: 3px solid #154879;padding-bottom: 5px;">
                                                            {{ __('txt.contest') }}</h4>
                                                        <ul style="">
                                                            <li>
                                                                <b>{{ __('txt.duration') }}:</b>
                                                                {{-- {{ $contest->duration }} --}}
                                                                @php
                                                                    $start_date = \Carbon\Carbon::parse($contest->contest_start_date);
                                                                    $end_date = \Carbon\Carbon::parse($contest->contest_end_date);
                                                                    $difference = $start_date->diff($end_date);
                                                                @endphp

                                                                @php
                                                                    $duration = '';
                                                                    if ($difference->y > 0) {
                                                                        $duration .= (session('applocale') === 'bn' ? Bengali::bn_number($difference->y) : $difference->y) . __('txt.years') . ' ';
                                                                    }
                                                                    if ($difference->m > 0) {
                                                                        $duration .= (session('applocale') === 'bn' ? Bengali::bn_number($difference->m) : $difference->m) . __('txt.months') . ' ';
                                                                    }
                                                                    if ($difference->d > 0) {
                                                                        $duration .= (session('applocale') === 'bn' ? Bengali::bn_number($difference->d) : $difference->d) . __('txt.days');
                                                                    }
                                                                @endphp

                                                                {{ trim($duration) }}
                                                            </li>
                                                            <li>
                                                                <b>{{ __('txt.contest_start_date') }}:</b>
                                                                {{ session('applocale') === 'bn' ? Bengali::bn_date(\Carbon\Carbon::parse($contest->contest_start_date)->format('d F Y')) : \Carbon\Carbon::parse($contest->contest_start_date)->format('d F Y') }}
                                                            </li>
                                                            <li>
                                                                <b>{{ __('txt.contest_end_date') }}:</b>
                                                                {{ session('applocale') === 'bn' ? Bengali::bn_date(\Carbon\Carbon::parse($contest->contest_end_date)->format('d F Y')) : \Carbon\Carbon::parse($contest->contest_end_date)->format('d F Y') }}
                                                            </li>
                                                            <li>
                                                                <b>{{ __('txt.no_of_perticipant') }}:</b>
                                                                {{ session('applocale') === 'bn' ? Bengali::bn_number($contest->number_of_participation) : $contest->number_of_participation}}
                                                            </li>
                                                            <li>
                                                                <b>{{ __('txt.contest_ammount') }}:</b>
                                                                {{ session('applocale') === 'bn' ? Bengali::bn_number($contest->amount) : $contest->amount}}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4
                                                            style="font-size:20px; padding-bottom: 0;display: inline-block;border-bottom: 3px solid #154879;padding-bottom: 5px;">
                                                            {{ __('txt.registration') }}</h4>
                                                        <ul style="">
                                                            <li>
                                                                <b>{{ __('txt.reg_start_date') }}:</b>
                                                                {{ session('applocale') === 'bn' ? Bengali::bn_date(\Carbon\Carbon::parse($contest->registration_start_date)->format('d F Y')) : \Carbon\Carbon::parse($contest->registration_start_date)->format('d F Y') }}
                                                            </li>
                                                            <li>
                                                                <b>{{ __('txt.reg_end_date') }}:</b>
                                                                {{ session('applocale') === 'bn' ? Bengali::bn_date(\Carbon\Carbon::parse($contest->registration_end_date)->format('d F Y')) : \Carbon\Carbon::parse($contest->registration_end_date)->format('d F Y') }}
                                                            </li>
                                                            <li>
                                                                <a class="btn_3d"
                                                                    style="color:white !important;background: #154879;padding: 6px 15px;display: inline-block;margin-top: 10px;border-radius: 20px;font-size: 18px;"
                                                                    href="{{ route('demo.contest_details', $contest->slug) }}">{{ __('txt.view_details') }}</a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>



                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            @else
                                <p style="text-align: center;font-size: 20px;color: #666;">{{ __('txt.no_contest') }}</p>
                            @endif

                            {{-- @foreach ($contests as $contest)
                            @foreach ($contests as $contest)
                                <div class="col-lg-12 contest mb-4">
                                    <a href="">
                                        <div style="height: 100%;" class="card">
                                            <div class="card-header">
                                                <h3>{{ $contest->title }}</h3>
                                                <h6>
                                                    {{ substr($contest->short_description, 0, 60) }}
                                                    @if (strlen($contest->short_description) > 60)
                                                        <span id="dots">...</span>
                                                        <span id="more"
                                                            style="display: none;">{{ substr($contest->short_description, 50) }}</span>
                                                        <a style="color: white;text-decoration:underline"
                                                            onclick="showMore()" id="read-more-btn">Read
                                                            More</a>
                                                    @endif
                                                </h6>
                                            </div>
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-md-6" style="border-right: 1px solid gray">
                                                        <h4 style="padding-bottom: 0;display: inline-block;border-bottom: 3px solid #154879;padding-bottom: 5px;">Contest :</h4>
                                                        <ul style="">
                                                            <li>
                                                                <b>Duration:</b> {{ $contest->duration }}
                                                            </li>
                                                            <li>
                                                                <b>Contest Start Date:</b>
                                                                {{ $contest->contest_start_date }}
                                                            </li>
                                                            <li>
                                                                <b>Contest End Date:</b> {{ $contest->contest_end_date }}
                                                            </li>
                                                            <li>
                                                                <b>No. of Participants:</b>
                                                                {{ $contest->number_of_participation }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4 style="padding-bottom: 0;display: inline-block;border-bottom: 3px solid #154879;padding-bottom: 5px;">Registration</h4>
                                                        <ul style="">
                                                            <li>
                                                                <b>Registration Start Date:</b>
                                                                {{ $contest->registration_start_date }}
                                                            </li>
                                                            <li>
                                                                <b>Registration End Date:</b>
                                                                {{ $contest->registration_end_date }}
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>



                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                            {{-- @foreach ($contests as $contest)
                                <div class="col-lg-6 contest mb-4">
                                    <a href="">
                                        <div style="height: 100%;" class="card">
                                            <div class="card-header">
                                                <h3>{{ $contest->title }}</h3>
                                                <h6>
                                                    {{ substr($contest->short_description, 0, 60) }}
                                                    @if (strlen($contest->short_description) > 60)
                                                        <span id="dots">...</span>
                                                        <span id="more"
                                                            style="display: none;">{{ substr($contest->short_description, 50) }}</span>
                                                        <a style="color: white;text-decoration:underline"
                                                            onclick="showMore()" id="read-more-btn">Read
                                                            More</a>
                                                    @endif
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <h4 style="padding-bottom: 0">Registration</h4>
                                                <ul style="padding-left: 50px">
                                                    <li>
                                                        <b>Registration Start Date:</b>
                                                        {{ $contest->registration_start_date }}
                                                    </li>
                                                    <li>
                                                        <b>Registration End Date:</b>
                                                        {{ $contest->registration_end_date }}
                                                    </li>
                                                </ul>
                                                <h4 style="padding-bottom: 0">Contest</h4>
                                                <ul style="padding-left: 50px">
                                                    <li>
                                                        <b>Duration:</b> {{ $contest->duration }}
                                                    </li>
                                                    <li>
                                                        <b>Contest Start Date:</b> {{ $contest->contest_start_date }}
                                                    </li>
                                                    <li>
                                                        <b>Contest End Date:</b> {{ $contest->contest_end_date }}
                                                    </li>
                                                    <li>
                                                        <b>No. of Participants:</b>
                                                        {{ $contest->number_of_participation }}
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach --}}
                        </div>
                    </div>




                    <div class="col-lg-4 demo-sidebar">

                        @if (isset($video->video_one))
                            <div class="content-container mb-4 wow animate__fadeIn iframe" data-wow-duration="3s">
                                {!! $video->video_one !!}
                                </iframe>
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






    </main>





@endsection
