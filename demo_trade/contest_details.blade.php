@extends('layouts.demo_master')
@section('content')
    <main>
        <div style="height: 135px" class="demo_section main-slider">
            <div style="height: 135px" class="container main-slider__container">
                <div class="main-slider__bg bg">

                    <div class="bg__item bg__item_gradient"></div>
                </div>
                <div style="height: 135px" class="content main-slider__content">
                    <div style="min-height: 135px;padding:0;transform: translateY(60px);" class="main-slider__in">

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

                        <div class="content-container mb-4 wow animate__fadeIn" data-wow-duration="3s">
                            <div class="d-flex align-items-center">
                                <h3 style="margin-bottom: 0px;">{{ __('txt.reg_status') }}</h3>
                                @if (now() > $contest->registration_end_date)
                                    <div class="badge bg-danger m-3">{{ __('txt.registration_closed') }}</div>
                                @endif
                            </div>


                            <p>
                                @if (now() > $contest->registration_end_date)
                                    {{ session('applocale') === 'bn' ? $contest->contest_status_close_bn : $contest->contest_status_close }}
                                @else
                                    {{ session('applocale') === 'bn' ? $contest->contest_status_open_bn : $contest->contest_status_open }}
                                @endif
                            </p>
                            @if ($contest->registration_start_date <= now() && now() <= $contest->registration_end_date)
                                <div class="d-flex justify-content-between align-items-center">
                                    @auth
                                        @if ($isenrolled)
                                            <p class="enroll-btn disabled"
                                                style="color:gray !important; border:1px solid whitesmoke;background-color:whitesmoke">
                                                {{ __('txt.enrolled') }}
                                            </p>
                                        @else
                                            <p style="margin: 0">{{ now()->diffInDays($contest->registration_end_date) }}
                                                {{ __('txt.days_left_of_registration') }}</p>
                                            <a data-bs-toggle="modal" data-bs-target="#enrollmodal" class="enroll-btn"
                                                style="color:white !important">
                                                {{ __('txt.enroll') }}
                                            </a>
                                        @endif
                                    @else
                                        <a href="#" class="enroll-btn" style="color:white !important"
                                            data-bs-toggle="modal" data-bs-target="#loginmodal">
                                            {{ __('txt.enroll') }}
                                        </a>
                                    @endauth
                                </div>
                            @endif
                        </div>



                        @if (count($contestLeaderboardTopTenUsers) > 0)
                            <div class="content-container mb-4 wow animate__fadeIn" data-wow-duration="3s">
                                <h3>{{ __('txt.leaderboard_h') }}</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('txt.full_name') }}</th>
                                                <th>{{ __('txt.portfolio_value') }}</th>
                                                <th>{{ __('txt.transaction_value') }}</th>
                                                <th>{{ __('txt.rank') }}</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            {{-- <tr>
                                            <td>Faisal Abdul Sattar</td>
                                            <td>8,605,683,290,530.00</td>
                                            <td>203,085,305,936,448.00</td>
                                            <td>1</td>
                                        </tr> --}}
                                            @foreach ($contestLeaderboardTopTenUsers as $index => $user)
                                                @if ($user->user_rank)
                                                    <tr>
                                                        <td>{{ $user->full_name }}</td>
                                                        <td>{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($user->totalCurrentValueForSingleUser, 2)) : number_format($user->totalCurrentValueForSingleUser, 2) }}
                                                        </td>
                                                        <td>
                                                            {{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($user->transaction_value, 2)) : number_format($user->transaction_value, 2) }}
                                                            </td>
                                                        <td>{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($user->user_rank, 0)) : number_format($user->user_rank, 2) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        @endif





                        @if (count($prizes) > 0)
                            <div class="content-container mb-4 wow animate__fadeIn" data-wow-duration="3s">

                                <h3 style="margin-bottom: 30px;">{{ __('txt.prizes') }}</h3>

                                <div class="row">


                                    @foreach ($prizes as $prize)
                                        <div class="col-md-4">
                                            <div class="card prize">
                                                <div class="card-body text-center">


                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <path
                                                            d="M173.8 5.5c11-7.3 25.4-7.3 36.4 0L228 17.2c6 3.9 13 5.8 20.1 5.4l21.3-1.3c13.2-.8 25.6 6.4 31.5 18.2l9.6 19.1c3.2 6.4 8.4 11.5 14.7 14.7L344.5 83c11.8 5.9 19 18.3 18.2 31.5l-1.3 21.3c-.4 7.1 1.5 14.2 5.4 20.1l11.8 17.8c7.3 11 7.3 25.4 0 36.4L366.8 228c-3.9 6-5.8 13-5.4 20.1l1.3 21.3c.8 13.2-6.4 25.6-18.2 31.5l-19.1 9.6c-6.4 3.2-11.5 8.4-14.7 14.7L301 344.5c-5.9 11.8-18.3 19-31.5 18.2l-21.3-1.3c-7.1-.4-14.2 1.5-20.1 5.4l-17.8 11.8c-11 7.3-25.4 7.3-36.4 0L156 366.8c-6-3.9-13-5.8-20.1-5.4l-21.3 1.3c-13.2 .8-25.6-6.4-31.5-18.2l-9.6-19.1c-3.2-6.4-8.4-11.5-14.7-14.7L39.5 301c-11.8-5.9-19-18.3-18.2-31.5l1.3-21.3c.4-7.1-1.5-14.2-5.4-20.1L5.5 210.2c-7.3-11-7.3-25.4 0-36.4L17.2 156c3.9-6 5.8-13 5.4-20.1l-1.3-21.3c-.8-13.2 6.4-25.6 18.2-31.5l19.1-9.6C65 70.2 70.2 65 73.4 58.6L83 39.5c5.9-11.8 18.3-19 31.5-18.2l21.3 1.3c7.1 .4 14.2-1.5 20.1-5.4L173.8 5.5zM272 192a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM1.3 441.8L44.4 339.3c.2 .1 .3 .2 .4 .4l9.6 19.1c11.7 23.2 36 37.3 62 35.8l21.3-1.3c.2 0 .5 0 .7 .2l17.8 11.8c5.1 3.3 10.5 5.9 16.1 7.7l-37.6 89.3c-2.3 5.5-7.4 9.2-13.3 9.7s-11.6-2.2-14.8-7.2L74.4 455.5l-56.1 8.3c-5.7 .8-11.4-1.5-15-6s-4.3-10.7-2.1-16zm248 60.4L211.7 413c5.6-1.8 11-4.3 16.1-7.7l17.8-11.8c.2-.1 .4-.2 .7-.2l21.3 1.3c26 1.5 50.3-12.6 62-35.8l9.6-19.1c.1-.2 .2-.3 .4-.4l43.2 102.5c2.2 5.3 1.4 11.4-2.1 16s-9.3 6.9-15 6l-56.1-8.3-32.2 49.2c-3.2 5-8.9 7.7-14.8 7.2s-11-4.3-13.3-9.7z" />
                                                    </svg>
                                                    <h4>{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($prize->rank, 0)) : number_format($prize->rank, 2) }}</h4>
                                                    <h5>{{ session('applocale') === 'bn' ? Bengali::bn_number($prize->award) : $prize->award}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach



                                </div>
                            </div>
                        @endif

                        <div class="content-container mb-4 wow animate__fadeIn" data-wow-duration="3s">
                            {{-- <h3>The Challenge</h3> --}}
                            <div>{!! session('applocale') === 'bn' ? $contest->long_description_bn : $contest->long_description !!}</div>

                            {{-- <p>The Challenge
                                My Portfolio Contest and learn about investing on the Exchange in real time, taking
                                decisions in investing against real stock prices but through virtual money. Win attractive
                                prizes while learning the ropes of investing on PSX through the My Portfolio Contest. There
                                is much to gain and learn - with nothing to lose! So join in and register for My Portfolio
                                Contest today! <br><br>

                                By participating in My Portfolio Contest, you will be able to learn about investing,
                                building a portfolio and taking investment decisions. You can learn about stock prices,
                                index movement, stock symbols and much more. You can also demonstrate your learned skills of
                                taking prudent investment decisions through this productive and engaging contest. <br><br>

                                The contest shall be a two-month long activity in which the users will be allocated PKR 10
                                million virtual cash in their portfolio and, during the provided timeline, users will be
                                asked to invest and trade by buying and selling shares. The top performing portfolios, in
                                the final analysis, will be rewarded. The contest is focused on encouraging potential
                                investors to explore the market, make the right decisions and learn from their mistakes
                                without incurring any real cash losses.
                            </p> --}}
                        </div>

                        {{-- <div class="content-container mb-4">
                            <h3>My Portfolio</h3>
                            <p>
                                Sheba Capital's My portfolio web-app provides an opportunity to users to learn about
                                building portfolio(s) by virtually investing and taking investment decisions using virtual
                                cash. Our virtual stock market portfolio tool can be used both in the classroom to help
                                students learn about the stock market and personal finance or individually to practice
                                trading real stocks at real prices, without risking real money. PSX now presents the My
                                Portfolio Contest, a challenging and highly engaging contest where you can exercise your
                                investment skills and learn about investing while not taking any financial risk.
                            </p>
                        </div> --}}

                        <div class="content-container mb-4 wow animate__fadeIn" data-wow-duration="3s">
                            {{-- <h3>Who can register and how to register?</h3> --}}
                            <div>{!! session('applocale') === 'bn' ? $contest->who_can_register_bn : $contest->who_can_register !!}</div>




                        </div>



                        <div class="content-container mb-4 contest-box wow animate__fadeIn" data-wow-duration="3s">
                            <h3>{{ session('applocale') === 'bn' ? $contest->title_bn : $contest->title }}</h3>
                            <h6>{{ session('applocale') === 'bn' ? $contest->short_description_bn : $contest->short_description }}
                            </h6>
                            <h4 style="padding-bottom: 0">{{ __('txt.registration') }}</h4>
                            <ul style="padding-left: 50px">
                                <li>
                                    <b>{{ __('txt.reg_start_date') }}:</b>
                                    {{ session('applocale') === 'bn' ? Bengali::bn_date(\Carbon\Carbon::parse($contest->registration_start_date)->format('d F Y')) : \Carbon\Carbon::parse($contest->registration_start_date)->format('d F Y') }}
                                </li>
                                <li>
                                    <b>{{ __('txt.reg_end_date') }}:</b>
                                    {{ session('applocale') === 'bn' ? Bengali::bn_date(\Carbon\Carbon::parse($contest->registration_end_date)->format('d F Y')) : \Carbon\Carbon::parse($contest->registration_end_date)->format('d F Y') }}
                                </li>
                            </ul>
                            <h4 style="padding-bottom: 0">{{ __('txt.contest') }}</h4>
                            <ul style="padding-left: 50px">
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
                                    {{ session('applocale') === 'bn' ? Bengali::bn_number($contest->number_of_participation) : $contest->number_of_participation }}
                                </li>
                                <li>
                                    <b>{{ __('txt.contest_ammount') }}:</b>
                                    {{ session('applocale') === 'bn' ? Bengali::bn_number($contest->amount) : $contest->amount }}
                                </li>
                            </ul>

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
                        <div class="content-container mb-4 wow animate__fadeIn" data-wow-duration="3s">
                            <h3>{{ __('txt.terms_and_conditions') }}</h3>
                            <img width="100%" src="{{ URL::asset('uploads/demo/image/demo.png') }}" alt=""
                                class="pdf-viewer" data-pdf-path="{{ URL::asset('uploads/demo/pdf/demo.pdf') }}">
                            <div class="text-center mt-3" class="button">
                                {{-- <span style="background: #003b72;font-weight:600" class="btn btn-primary pdf-viewer"
                                    data-pdf-path="{{ URL::asset('uploads/demo/pdf/demo.pdf') }}">Read More</span> --}}
                                <button style="background: #003b72;font-weight:600" type="button" class="btn btn-primary"
                                    data-bs-toggle="modal" data-bs-target="#terms">
                                    {{ __('txt.read_more') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- Term and Condition Modal -->
        <div class="modal fade" id="terms" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('txt.terms_and_conditions') }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {!! session('applocale') === 'bn' ? $contest->terms_and_condition_bn : $contest->terms_and_conditions !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                            style="padding: 10px 20px;background: #043b70;border-radius: 10px;color: white;"
                            data-bs-dismiss="modal">{{ __('txt.close_button') }}</button>

                    </div>
                </div>
            </div>
        </div>





        {{-- prize Modal --}}

        <div class="modal fade" id="prizeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('txt.prizes') }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="content-container mb-4 p-4">
                            {{-- <h3 style="margin-bottom: 30px;">Awards</h3> --}}

                                <div class="row">


                                    @foreach ($prizes as $prize)
                                        <div class="col-md-4">
                                            <div class="card prize">
                                                <div class="card-body text-center">


                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <path
                                                            d="M173.8 5.5c11-7.3 25.4-7.3 36.4 0L228 17.2c6 3.9 13 5.8 20.1 5.4l21.3-1.3c13.2-.8 25.6 6.4 31.5 18.2l9.6 19.1c3.2 6.4 8.4 11.5 14.7 14.7L344.5 83c11.8 5.9 19 18.3 18.2 31.5l-1.3 21.3c-.4 7.1 1.5 14.2 5.4 20.1l11.8 17.8c7.3 11 7.3 25.4 0 36.4L366.8 228c-3.9 6-5.8 13-5.4 20.1l1.3 21.3c.8 13.2-6.4 25.6-18.2 31.5l-19.1 9.6c-6.4 3.2-11.5 8.4-14.7 14.7L301 344.5c-5.9 11.8-18.3 19-31.5 18.2l-21.3-1.3c-7.1-.4-14.2 1.5-20.1 5.4l-17.8 11.8c-11 7.3-25.4 7.3-36.4 0L156 366.8c-6-3.9-13-5.8-20.1-5.4l-21.3 1.3c-13.2 .8-25.6-6.4-31.5-18.2l-9.6-19.1c-3.2-6.4-8.4-11.5-14.7-14.7L39.5 301c-11.8-5.9-19-18.3-18.2-31.5l1.3-21.3c.4-7.1-1.5-14.2-5.4-20.1L5.5 210.2c-7.3-11-7.3-25.4 0-36.4L17.2 156c3.9-6 5.8-13 5.4-20.1l-1.3-21.3c-.8-13.2 6.4-25.6 18.2-31.5l19.1-9.6C65 70.2 70.2 65 73.4 58.6L83 39.5c5.9-11.8 18.3-19 31.5-18.2l21.3 1.3c7.1 .4 14.2-1.5 20.1-5.4L173.8 5.5zM272 192a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM1.3 441.8L44.4 339.3c.2 .1 .3 .2 .4 .4l9.6 19.1c11.7 23.2 36 37.3 62 35.8l21.3-1.3c.2 0 .5 0 .7 .2l17.8 11.8c5.1 3.3 10.5 5.9 16.1 7.7l-37.6 89.3c-2.3 5.5-7.4 9.2-13.3 9.7s-11.6-2.2-14.8-7.2L74.4 455.5l-56.1 8.3c-5.7 .8-11.4-1.5-15-6s-4.3-10.7-2.1-16zm248 60.4L211.7 413c5.6-1.8 11-4.3 16.1-7.7l17.8-11.8c.2-.1 .4-.2 .7-.2l21.3 1.3c26 1.5 50.3-12.6 62-35.8l9.6-19.1c.1-.2 .2-.3 .4-.4l43.2 102.5c2.2 5.3 1.4 11.4-2.1 16s-9.3 6.9-15 6l-56.1-8.3-32.2 49.2c-3.2 5-8.9 7.7-14.8 7.2s-11-4.3-13.3-9.7z" />
                                                    </svg>
                                                    <h4>{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($prize->rank, 0)) : number_format($prize->rank, 2) }}</h4>
                                                    <h5>{{ session('applocale') === 'bn' ? Bengali::bn_number($prize->award) : $prize->award}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach



                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button"
                            style="padding: 10px 20px;background: #043b70;border-radius: 10px;color: white;"
                            data-bs-dismiss="modal">Close</button> --}}

                    </div>
                </div>
            </div>
        </div>














        <script>
            @if (session('from') === 'loginform')
                $(document).ready(function() {
                    $('#loginmodal').modal('show');
                });
            @endif
        </script>


        @if (count($prizes) > 0)
            <script>
                // Use jQuery to trigger the modal when the page loads
                $(document).ready(function() {
                    $('#prizeModal').modal('show');
                });
            </script>
        @endif






    </main>
@endsection
