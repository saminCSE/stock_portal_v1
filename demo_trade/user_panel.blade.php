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
                    <div class="left col-md-6 wow animate__fadeIn" data-wow-duration="3s">
                        <h4>{{ __('txt.my_contest_heading') }}</h4>
                    </div>
                    <div class="right col-md-6 text-end wow animate__fadeIn" data-wow-duration="3s">
                        <a href="{{ route('profile') }}"
                            class="btn btn-primary-outline log_out">{{ __('txt.profile_link') }}</a>
                    </div>
                </div>



                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="portfolio_trend_container_custom overflow-hidden">
                            <h4 class="wow animate__fadeIn" data-wow-duration="3s">{{ __('txt.enrolled_contest') }}</h4>
                            <hr>
                            <div class="row mt-4">


                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($contestsEnrolledIn as $contest)
                                    @if (now() <= $contest->contest_end_date)
                                        @php
                                            $count = 1;
                                        @endphp
                                        <div class="col-lg-6 contest mb-4 wow animate__fadeIn" data-wow-duration="3s">
                                            <a style="height: 100%;display: inline-block;"
                                                href="{{ route('demo.contest.panel', $contest->slug) }}">
                                                <div style="height: 100%;" class="card">
                                                    <div class="card-header d-flex position-relative">

                                                        @if ($contest->contest_start_date <= now() && now() <= $contest->contest_end_date)
                                                            <span
                                                                class="blink contest-status position-absolute badge rounded-pill bg-success">
                                                                {{ __('txt.contest_active') }}
                                                            </span>
                                                        @elseif (now() > $contest->contest_end_date)
                                                            <span
                                                                class="contest-status position-absolute badge rounded-pill bg-secondary">
                                                                {{ __('txt.contest_ended') }}
                                                            </span>
                                                        @elseif (now() < $contest->contest_start_date)
                                                            <span
                                                                class="contest-status position-absolute badge rounded-pill bg-info">
                                                                {{ __('txt.contest_not_started') }}
                                                            </span>
                                                        @endif

                                                        <div class="header-content">
                                                            <h3>{{ session('applocale') === 'bn' ? $contest->title_bn : $contest->title }}
                                                            </h3>
                                                            <h6>
                                                                @php
                                                                    $short_description = session('applocale') === 'bn' ? $contest->short_description_bn : $contest->short_description;
                                                                @endphp
                                                                {{ mb_substr($short_description, 0, 80) }}
                                                                @if (strlen($short_description) > 80)
                                                                    <span id="dots-{{ $contest->id }}">...</span>
                                                                    <span id="more-{{ $contest->id }}"
                                                                        style="display: none;">{{ substr($short_description, 80) }}</span>
                                                                    {{-- <span style="color: rgb(96, 139, 218)!important; text-decoration: underline" onclick="showMore({{ $contest->id }})" id="read-more-btn-{{ $contest->id }}">Read More</span> --}}
                                                                    <span
                                                                        style="color: rgb(96, 139, 218)!important; text-decoration: none">{{ __('txt.read_more') }}</span>
                                                                @endif
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
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
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                                @if ($count == 0)
                                    <p style="text-align: center;font-size: 20px;color: #666;">{{ __('txt.no_contest') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">

                        {{-- History --}}
                        <div class="portfolio_trend_container_custom mb-4">
                            <h4 class="wow animate__fadeIn" data-wow-duration="3s">{{ __('txt.history') }}</h4>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12 contest mb-4">
                                    <div style="height: 100%;" class="card1">
                                        <div class="card-body wow animate__fadeIn" data-wow-duration="3s">

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">{{ __('txt.contest_name') }}</th>
                                                            <th scope="col">{{ __('txt.rank') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $count = 0;
                                                        @endphp
                                                        @foreach ($contestsEnrolledIn as $contest)
                                                            @if (now() > $contest->contest_end_date)
                                                                @php
                                                                    $count = 1;
                                                                @endphp
                                                                <tr class="">
                                                                    <td scope="row"><a
                                                                            href="{{ route('demo.contest.panel', $contest->slug) }}">{{ session('applocale') === 'bn' ? $contest->title_bn : $contest->title }}</a>
                                                                    </td>
                                                                    <td>{{ $contest->rank_position }}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @if ($count == 0)
                                                    <p style="text-align: center;font-size: 20px;color: #666;">
                                                        {{ __('txt.no_contest') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- All Contest --}}
                        <div class="portfolio_trend_container_custom mb-4">
                            <h4 class="wow animate__fadeIn" data-wow-duration="3s">{{ __('txt.all_contests') }}</h4>
                            <hr>
                            <div class="row mt-4">
                                <div class="col-lg-12 contest mb-4">
                                    <div style="height: 100%;" class="card1">
                                        <div class="card-body wow animate__fadeIn" data-wow-duration="3s">

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody class="">
                                                        @php
                                                            $count = 0;
                                                        @endphp
                                                        @foreach ($contests as $contest)
                                                            @if ($contest->registration_start_date <= now() && now() <= $contest->registration_end_date)
                                                                @php
                                                                    $count = 1;
                                                                @endphp
                                                                <tr class="">
                                                                    <td><a class=""
                                                                            href="{{ route('demo.contest_details', $contest->slug) }}">
                                                                            <h6>{{ session('applocale') === 'bn' ? $contest->title_bn : $contest->title }}</h6>
                                                                        </a></td>
                                                                    <td><a data-bs-toggle="modal"
                                                                            data-bs-target="#enrollmodal{{ $contest->id }}"
                                                                            class="badge"
                                                                            style="color:white !important; background-color:#003b72;">{{ __('txt.enroll') }}</a>
                                                                        {{-- Enroll Modal --}}
                                                                        <div class="modal fade"
                                                                            id="enrollmodal{{ $contest->id }}"
                                                                            tabindex="-1"
                                                                            aria-labelledby="exampleModalLabel"
                                                                            aria-hidden="true">
                                                                            <div
                                                                                class="modal-dialog modal-dialog-centered modal-xl">
                                                                                <div class="modal-content">
                                                                                    <div
                                                                                        class="modal-header justify-content-between">
                                                                                        <div></div>
                                                                                        <h1 style="color:#021d46;font-weight:bold"
                                                                                            class="modal-title fs-5"
                                                                                            id="exampleModalLabel">
                                                                                            {{ __('txt.terms_and_conditions') }}
                                                                                        </h1>
                                                                                        <button style="margin: 0;padding:0"
                                                                                            type="button" class="btn-close"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        {!! session('applocale') === 'bn' ? $contest->terms_and_condition_bn : $contest->terms_and_conditions !!}
                                                                                        <form
                                                                                            action="{{ route('demo.user.enroll', $contest->slug) }}">
                                                                                            @csrf
                                                                                            <div class="form-check">
                                                                                                <input class=""
                                                                                                    style="width: 15px; height:15px"
                                                                                                    type="checkbox"
                                                                                                    name="agree"
                                                                                                    id="agreeCheckbox"
                                                                                                    required>
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="agreeCheckbox">
                                                                                                    I agree to the Terms and
                                                                                                    Conditions</a>
                                                                                                </label>
                                                                                            </div>

                                                                                            <br>

                                                                                            <button type="submit"contest
                                                                                                class="enroll-btn">{{ __('txt.enroll') }}</button>
                                                                                        </form>
                                                                                    </div>

                                                                                </div>


                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @if ($count == 0)
                                                    <p style="text-align: center;font-size: 20px;color: #666;">
                                                        {{ __('txt.no_contest') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
