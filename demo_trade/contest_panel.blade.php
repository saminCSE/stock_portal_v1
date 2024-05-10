@extends('layouts.demo_master')
@section('content')
    <main>
        <div style="height: 200px" class="demo_section main-slider">
            <div style="height: 200px" class="container main-slider__container">
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
                <div style="height: 200px" class="content main-slider__content">
                    <div style="min-height: 200px;padding:0;transform: translateY(60px);" class="main-slider__in">
                        <h3 style="margin-bottom: 0px;" class="" style=""></h3>
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
        <div class="main_panel">
            <div class="container">
                <div class="demo-nav row">
                    <div class="left col-md-6 wow animate__fadeIn" data-wow-duration="3s">
                        <div>
                            <h4 class="m-0">{{ $broker_details ? $broker_details->portfolio_name : (session('applocale') === 'bn' ? $contest->title_bn : $contest->title) }}
                            </h4>
                            <p class="text-white m-0">{{ $broker_details ? $broker_details->broker_house_name : '' }}<i>
                                    {{ $broker_details ? '(' . $broker_details->branch_name . ' Branch)' : '' }}</i></p>
                        </div>

                    </div>
                    <div class="right col-md-6 text-end wow animate__fadeIn d-flex align-items-center justify-content-end"
                        data-wow-duration="3s">
                        <div>


                            @if ($contest->slug == env('Free_demo_slug', 'free-demo'))
                                <a class="btn btn-primary-outline" data-bs-toggle="modal"
                                    data-bs-target="#brokerage_settings_modal">{{ trans('txt.portfolio_settings') }}</a>
                            @endif

                            @if ($contest->slug == env('Free_demo_slug', 'free-demo'))
                                <a class="btn btn-primary-outline" data-bs-toggle="modal"
                                    data-bs-target="#deposit_modal">{{ __('txt.deposit_amount') }}</a>
                            @endif



                            @if ($contest->contest_start_date <= now() && now() <= $contest->contest_end_date)
                                @if ($is_open || 1)
                                    {{-- Show the button --}}
                                    <a href="{{ route('make.trade', $contest->slug) }}"
                                        class="btn btn-primary-outline">{{ __('txt.make_trade') }}</a>
                                @else
                                    <p class="badge bg-danger">{{ __('txt.trading_time') }}</p>
                                @endif
                            @endif
                        </div>


                        {{-- <a href="" class="btn btn-primary-outline">Create New Portfolio</a>
                        <a href="" class="btn btn-primary-outline">Edit Portfolio</a> --}}
                        {{-- <a href="{{ route('demo.logout') }}" class="btn btn-primary-outline log_out">logout</a> --}}
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4 col-lg mb-3 wow animate__fadeIn" data-wow-duration="3s">
                        <div class="content_box">
                            <h6 class="title">{{ __('txt.todays_return') }}</h6>
                            <h2 class="number1" id="todays_return">0.00</h2>
                            {{-- <h3 class="number2">+0.00%</h3> --}}
                        </div>
                    </div>
                    <div class="col-md-4 col-lg mb-3 wow animate__fadeIn" data-wow-duration="3s">
                        <div class="content_box">
                            <h6 class="title">{{ __('txt.total_return') }}</h6>
                            <h2 class="number1">{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($neat_gain, 2)) : number_format($neat_gain, 2) }}</h2>
                            {{-- <h3 class="number2">+0.00%</h3> --}}
                        </div>
                    </div>
                    <div class="col-md-4 col-lg mb-3 wow animate__fadeIn" data-wow-duration="3s">
                        <div class="content_box">
                            <h6 class="title">{{ __('txt.market_value_of_equities') }}</h6>
                            <h2 class="number1">{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($totalCurrentValue, 2)) : number_format($totalCurrentValue, 2) }}</h2>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg mb-3 wow animate__fadeIn" data-wow-duration="3s">
                        <div class="content_box">
                            <h6 class="title">{{ __('txt.cash') }}</h6>
                            <h2 class="number1">{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($contest_profiles->balance, 2)) : number_format($contest_profiles->balance, 2) }}</h2>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg mb-3 wow animate__fadeIn" data-wow-duration="3s">
                        <div class="content_box">
                            <h6 class="title">{{ __('txt.total_portfolio_value') }}</h6>
                            <h2 class="number1">{{  session('applocale') === 'bn' ? Bengali::bn_number(number_format($totalCurrentValue + $contest_profiles->balance, 2)) : number_format($totalCurrentValue + $contest_profiles->balance, 2)}}</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-8 wow animate__fadeIn" data-wow-duration="3s">
                        <div class="portfolio_trend_container">
                            <h4>{{ __('txt.portfolio_trend') }}</h4>
                            <div id="portfolio_trend"></div>
                        </div>
                    </div>
                    <div class="col-md-4 wow animate__fadeIn" data-wow-duration="3s">
                        <div class="portfolio_trend_container">
                            <h4>{{ __('txt.sectors') }}</h4>
                            <div id="portfolio_breakdown"></div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="portfolio_table_container wow animate__fadeIn" data-wow-duration="3s">
                            <h4>{{ __('txt.portfolio_trend') }}</h4>
                            <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home"
                                        role="tab" aria-controls="home"
                                        aria-selected="true">{{ __('txt.summery') }}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                                        aria-controls="profile"
                                        aria-selected="false">{{ __('txt.transaction_history') }}</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('txt.sl') }}</th>
                                                    <th>{{ __('txt.instrument_code') }}</th>
                                                    <th>{{ __('txt.saleable_quantity') }}</th>
                                                    <th>{{ __('txt.lock_quantity') }}</th>
                                                    <th>{{ __('txt.total_quantity') }}</th>
                                                    <th>{{ __('txt.cost') }}</th>
                                                    {{-- <th>{{ __('txt.total_sale') }}</th> --}}
                                                    {{-- <th>{{ __('txt.saleable_quantity') }}</th> --}}
                                                    {{-- <th>{{ __('txt.pending_holding_quantity') }}</th> --}}
                                                    <th>{{ __('txt.cost_amount') }}</th>
                                                    {{-- <th>{{ __('txt.total_sale_value') }}</th> --}}
                                                    <th>{{ __('txt.market_price') }}</th>
                                                    <th>{{ __('txt.market_value') }}</th>
                                                    <th>{{ __('txt.portfolio') }}</th>
                                                    <th>{{ __('txt.unrealized_gain') }}</th>
                                                    <th>{{ __('txt.gain') }}</th>
                                                    {{-- <th>{{ __('txt.current_avg_cost') }}</th> --}}

                                                </tr>
                                            </thead>
                                            <tbody id="contest_portfolio_tbody">
                                                @php
                                                    $total_cost_value = 0;
                                                    $total_market_value = 0;
                                                    $todays_return = 0;
                                                @endphp
                                                @foreach ($contest_portfolios as $contest_portfolio)
                                                    @php
                                                        $total_market_value = $total_market_value + ($contest_portfolio->saleable_quantity + $contest_portfolio->pending_holding_quantity) * $contest_portfolio->market_price;
                                                    @endphp
                                                @endforeach
                                                @foreach ($contest_portfolios as $contest_portfolio)
                                                    <tr>
                                                        <td>{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($loop->iteration, 0)) : number_format($loop->iteration, 0) }}</td>
                                                        <td>{{ $contest_portfolio->instrument_code }}</td>
                                                        <td>{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($contest_portfolio->saleable_quantity, 0)) : number_format($contest_portfolio->saleable_quantity, 0) }}</td>
                                                        <td>{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($contest_portfolio->pending_holding_quantity, 0)) : number_format($contest_portfolio->pending_holding_quantity, 0)}}</td>
                                                        <td>{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($contest_portfolio->saleable_quantity + $contest_portfolio->pending_holding_quantity, 0)) : number_format($contest_portfolio->saleable_quantity + $contest_portfolio->pending_holding_quantity, 0) }}
                                                        </td>
                                                        <td>{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($contest_portfolio->current_avg_cost, 2)) : number_format($contest_portfolio->current_avg_cost, 2) }}

                                                        </td>

                                                        <td>{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format(($contest_portfolio->saleable_quantity + $contest_portfolio->pending_holding_quantity) * $contest_portfolio->current_avg_cost, 2)) : number_format(($contest_portfolio->saleable_quantity + $contest_portfolio->pending_holding_quantity) * $contest_portfolio->current_avg_cost, 2) }}</td>

                                                        @php
                                                          $total_cost_value = $total_cost_value + ($contest_portfolio->saleable_quantity + $contest_portfolio->pending_holding_quantity) * $contest_portfolio->current_avg_cost;
                                                        @endphp

                                                        <td>{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($contest_portfolio->market_price, 2)) : number_format($contest_portfolio->market_price, 2) }}</td>
                                                        <td>{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format(($contest_portfolio->saleable_quantity + $contest_portfolio->pending_holding_quantity) * $contest_portfolio->market_price, 2)) : number_format(($contest_portfolio->saleable_quantity + $contest_portfolio->pending_holding_quantity) * $contest_portfolio->market_price, 2) }}</td>


                                                        <td style="color: green">
                                                            @if ($total_market_value)
                                                                {{ session('applocale') === 'bn' ? Bengali::bn_number(number_format(((($contest_portfolio->saleable_quantity + $contest_portfolio->pending_holding_quantity) * $contest_portfolio->market_price) / $total_market_value) * 100, 2)) : number_format(((($contest_portfolio->saleable_quantity + $contest_portfolio->pending_holding_quantity) * $contest_portfolio->market_price) / $total_market_value) * 100, 2) }}%
                                                            @else
                                                                {{session('applocale') === 'bn' ? Bengali::bn_number(number_format(0, 2)) : number_format(0, 2)}}%
                                                            @endif
                                                        </td>
                                                        @php
                                                            $gain = ($contest_portfolio->saleable_quantity + $contest_portfolio->pending_holding_quantity) * $contest_portfolio->market_price - ($contest_portfolio->saleable_quantity + $contest_portfolio->pending_holding_quantity) * $contest_portfolio->current_avg_cost;
                                                        @endphp
                                                        <td style="color: {{ $gain > 0 ? 'green' : 'red' }}">
                                                            {{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($gain, 2)) : number_format($gain, 2) }}
                                                            @php
                                                                $todays_return = $todays_return + $gain;
                                                            @endphp
                                                        </td>
                                                        @if ($gain && (($contest_portfolio->saleable_quantity + $contest_portfolio->pending_holding_quantity) * $contest_portfolio->current_avg_cost))
                                                            <td style="color: {{ $gain >= 0 ? 'green' : 'red' }}">
                                                                {{ session('applocale') === 'bn' ? Bengali::bn_number(number_format(($gain / (($contest_portfolio->saleable_quantity + $contest_portfolio->pending_holding_quantity) * $contest_portfolio->current_avg_cost)) * 100, 2)) : number_format(($gain / (($contest_portfolio->saleable_quantity + $contest_portfolio->pending_holding_quantity) * $contest_portfolio->current_avg_cost)) * 100, 2)}}%
                                                            </td>
                                                        @else
                                                            <td>
                                                                {{ session('applocale') === 'bn' ? Bengali::bn_number(number_format(0, 2)) : number_format(0, 2) }} %
                                                            </td>
                                                        @endif



                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>

                                        @if (count($contest_portfolios) == 0)
                                            <p style="color:#666;text-align:center"><i>{{ __('txt.no_record_found') }}</i>
                                            </p>
                                        @endif
                                        {{-- <div id="contest_portfolios_links">
                                            {{ $contest_portfolios->links() }}
                                        </div> --}}
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 offset-lg-9 col-md-4 offset-md-8">
                                            <table class="table">
                                                <tr class="w-100">
                                                    <th>{{ __('txt.total_cost') }}:</th>
                                                    <td class="text-end">{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($total_cost_value, 2)) : number_format($total_cost_value, 2) }}</td>
                                                </tr>
                                                <tr class="w-100">
                                                    <th>{{ __('txt.total_market_value') }}:</th>
                                                    <td class="text-end">{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($total_market_value, 2)) : number_format($total_market_value, 2) }}</td>
                                                </tr>
                                                <tr class="w-100">
                                                    @php
                                                        $gain_loss_label = $todays_return < 0 ? __('txt.loss') : __('txt.gain');
                                                        $color = $todays_return < 0 ? 'red' : 'green';
                                                    @endphp
                                                    <th style="color:{{ $color }}">{{ $gain_loss_label }}:</th>
                                                    <td class="text-end" style="color:{{ $color }}">{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format(abs($todays_return), 2)) : number_format(abs($todays_return), 2) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-responsive text-center">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('txt.sl') }}</th>
                                                    <th>{{ __('txt.stocks') }}</th>
                                                    <th>{{ __('txt.trade_date') }}</th>
                                                    <th>{{ __('txt.type') }}</th>
                                                    <th>{{ __('txt.stock_quantity') }}</th>
                                                    <th>{{ __('txt.share_price') }}</th>
                                                    {{-- <th>{{ __('txt.brokerage_share_bdt') }}</th> --}}
                                                    <th>{{ __('txt.transaction_value') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="transactionHistory_tbody">
                                                @foreach ($transactionHistoryes as $transactionHistory)
                                                    <tr>
                                                        <td>{{  session('applocale') === 'bn' ? Bengali::bn_number(number_format($loop->iteration, 2)) : number_format($loop->iteration, 2) }}</td>
                                                        <td>{{ $transactionHistory->instrument_code }}</td>
                                                        <td>{{  session('applocale') === 'bn' ? Bengali::bn_date(\Carbon\Carbon::parse($transactionHistory->purchase_date)->format('d-F-Y')) : \Carbon\Carbon::parse($transactionHistory->purchase_date)->format('d-F-Y')}}</td>


                                                        {{-- <td>{{$transactionHistory->side}}</td> --}}
                                                        <td>
                                                            @if ($transactionHistory->side === 'B')
                                                                {{ __('txt.buy') }}
                                                            @elseif($transactionHistory->side === 'S')
                                                            {{ __('txt.sell') }}
                                                            @endif
                                                        </td>
                                                        <td>{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($transactionHistory->quantity, 2)) : number_format($transactionHistory->quantity, 2) }}</td>
                                                        <td>{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($transactionHistory->price, 2)) : number_format($transactionHistory->price, 2) }}</td>
                                                        {{-- <td>{{$transactionHistory->}}</td> --}}
                                                        <td>{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($transactionHistory->value, 2)) : number_format($transactionHistory->value, 2) }}</td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @if (count($transactionHistoryes) == 0)
                                            <p style="color:#666;text-align:center"><i>{{ __('txt.no_record_found') }}</i>
                                            </p>
                                        @endif
                                        {{-- <div id="transactionHistory_history_links">
                                            {{ $transactionHistoryes->links() }}
                                        </div> --}}

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- Modal -->
        <div class="modal fade" id="deposit_modal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            <h3 class="text-center">

                            </h3>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <h4>{{ __('txt.confirm_deposit') }}</h4>
                        <h5>{{ __('txt.amount', ['amount' => $contest->amount]) }}</h5>

                    </div>
                    <div class="modal-footer justify-content-start">
                        <form action="{{ route('deposit_amount') }}" method="POST" class="deposit-validation"
                            novalidate>
                            @csrf
                            <div class="">
                                <input type="hidden" value="{{ $contest->amount }}" name="amount"
                                    class="form-control" id="inputNumber" required>
                            </div>

                            <button type="submit" class="enroll-btn">{{ __('txt.yes') }}</button>
                        </form>
                        <button type="button" class="enroll-btn deposit-btn" data-bs-dismiss="modal">
                            {{ __('txt.no') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if ($broker_details)
            <div class="modal fade" id="brokerage_settings_modal" data-bs-backdrop="static" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button> --}}
                        </div>
                        <form class="create_portfolio_form" action="{{ route('update.brokerage.details') }}"
                            method="POST">
                            @csrf
                            <div class="modal-body">

                                <h3 class="text-center mb-4">{{ trans('txt.portfolio_settings') }}</h3>


                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="brokerHouse" class="form-label">{{ __('txt.brokerHouse') }}</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="brokerHouse" name="brokerHouse"
                                            placeholder="{{ __('txt.brokerHouse') }}"
                                            value="{{ $broker_details->broker_house_name }}">

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
                                            value="{{ $broker_details->branch_name }}">

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
                                            value="{{ $broker_details->portfolio_name }}">

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
                                        <input type="text" class="form-control disabled" id="commissionRate"
                                            name="commissionRate" placeholder="{{ __('txt.commissionRate') }}"
                                            value="{{ $broker_details->commision_rate }}" readonly>

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
                                        <input type="text" class="form-control disabled" id="depositAmount"
                                            name="depositAmount" placeholder="{{ __('txt.depositAmount') }}"
                                            value="{{ $broker_details->deposite_amount }}" readonly>

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
        @endif


        <script>
            var modalId = document.getElementById('modalId');

            modalId.addEventListener('show.bs.modal', function(event) {
                // Button that triggered the modal
                let button = event.relatedTarget;
                // Extract info from data-bs-* attributes
                let recipient = button.getAttribute('data-bs-whatever');

                // Use above variables to manipulate the DOM
            });
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

        <script>
            @if (session('portfolioerror'))
                $(document).ready(function() {
                    $('#brokerage_settings_modal').modal('show');
                });
            @endif
        </script>



    </main>



@section('scripts')
    <script>
        $('#todays_return').text('{{ session('applocale') === 'bn' ? Bengali::bn_number(number_format($todays_return, 2)) : number_format($todays_return, 2) }}');
    </script>

    <script>
        var portfolioTrends = {!! json_encode($portfolioTrends) !!};
        var portfolio_values = portfolioTrends[3].portfolio_values.map(function(value) {
            return parseInt(value, 10);
        });


        var options = {
            series: [{
                name: 'PortfolioValue',
                data: portfolio_values
            }],
            chart: {
                height: 350,
                type: 'area',
            },
            stroke: {
                curve: 'smooth'
            },
            fill: {
                type: 'solid', // Use solid fill type
                colors: ['#008FFB'],
                opacity: 0.1, // Set opacity directly
            },
            labels: portfolioTrends[4].dates,
            markers: {
                size: 0
            },
            yaxis: [{
                title: {
                    text: 'PortfolioValue',
                },
            }],
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function(y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(0) + " points";
                        }
                        return y;
                    }
                }
            }
        };




        // Create a chart for the first container
        var portfolio_trend = new ApexCharts(document.querySelector("#portfolio_trend"), options);
        portfolio_trend.render();
    </script>
    <script>
        var breakdown = {!! json_encode($breakdown) !!}; // Convert PHP array to JavaScript object

        // Convert total_current_value strings to integers
        var totalCurrentValues = breakdown[1].total_current_value.map(function(value) {
            return parseInt(value, 10);
        });

        var options = {
            series: totalCurrentValues,
            chart: {
                width: 380,
                type: 'pie',
            },
            labels: breakdown[0].sector_names,
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };


        var portfolio_breakdown = new ApexCharts(document.querySelector("#portfolio_breakdown"), options);
        portfolio_breakdown.render();



        // Get Contest Portfolio with ajax

        $(document).ready(function() {
            // Click event on a button
            $(document).on("click", "#home .page-link", function(e) {
                console.log('Button clicked!');
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];

                // Ajax request
                $.ajax({
                    url: '{{ route('get_contest_portfolios', $contest->id) }}?page=' + page,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        items = data['data']['data'];
                        console.log(data['data']['links']);
                        tbody = "";
                        for (var i = 0; i < items.length; i++) {
                            var currentItem = items[i];
                            tbody += "<tr>";

                            tbody += "<td>";
                            tbody += i + 1;
                            tbody += "</td>";

                            tbody += "<td>";
                            tbody += currentItem['instrument_code'];
                            tbody += "</td>";

                            tbody += "<td>";
                            tbody += currentItem['total_buy'];
                            tbody += "</td>";

                            tbody += "<td>";
                            // Check for zero division before performing the division
                            if (currentItem['total_buy'] !== 0) {
                                tbody += currentItem['total_cost_value'] / currentItem[
                                    'total_buy'];
                            } else {
                                tbody += "N/A";
                            }
                            tbody += "</td>";

                            tbody += "<td>";
                            tbody += currentItem['total_cost_value'];
                            tbody += "</td>";

                            tbody += "<td>";
                            tbody += currentItem['market_price'];
                            tbody += "</td>";

                            tbody += "<td>";
                            tbody += currentItem['current_cost_value'];
                            tbody += "</td>";

                            tbody += "<td>";
                            // Check for zero division before performing the division
                            if (currentItem['total_cost_value'] !== 0) {
                                tbody += (currentItem['current_cost_value'] - currentItem[
                                        'total_cost_value']) / currentItem['total_cost_value'] *
                                    100;
                            } else {
                                tbody += "N/A";
                            }
                            tbody += "</td>";

                            tbody += "<td>";
                            tbody += currentItem['current_cost_value'] - currentItem[
                                'total_cost_value'];
                            tbody += "</td>";

                            tbody += "<td>";
                            // Check for zero division before performing the division
                            if (data['totalReturn'] !== 0) {
                                tbody += currentItem['current_cost_value'] / data[
                                    'totalReturn'];
                            } else {
                                tbody += "N/A";
                            }
                            tbody += "</td>";

                            tbody += "</tr>";
                        }
                        $('#contest_portfolio_tbody').html(tbody);
                        if (data['data']['links']) {
                            // Create Bootstrap-style pagination links
                            var linksHtml =
                                '<nav aria-label="Page navigation"><ul class="pagination">';
                            for (var j = 0; j < data['data']['links'].length; j++) {
                                var link = data['data']['links'][j];
                                var activeClass = link['active'] ? 'active' : '';
                                linksHtml += '<li class="page-item ' + activeClass +
                                    '"><a class="page-link" href="' +
                                    link['url'] + '">' + link['label'] + '</a></li>';
                            }
                            linksHtml += '</ul></nav>';
                            $('#contest_portfolios_links').html(linksHtml);
                        } else {
                            // If 'links' property is not present, handle it accordingly
                            console.error('No pagination links found in the response.');
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                        $('#result').html(
                            '<span style="color: red;">Error occurred while fetching data.</span>'
                        );
                    }
                });
            });
        });




        // Get Transaction History with ajax

        $(document).ready(function() {

            // Click event on a button
            $(document).on("click", "#profile .page-link", function(e) {
                console.log('Button clicked!');
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];

                // Ajax request
                $.ajax({
                    url: '{{ route('get_transactionHistory', $contest->id) }}?page=' + page,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        items = data['data']['data'];
                        console.log(data['data']['links']);
                        tbody = "";
                        for (var i = 0; i < items.length; i++) {
                            var currentItem = items[i];
                            tbody += "<tr>";

                            tbody += "<td>";
                            tbody += i + 1;
                            tbody += "</td>";

                            tbody += "<td>";
                            tbody += currentItem['instrument_code'];
                            tbody += "</td>";

                            tbody += "<td>";
                            tbody += currentItem['purchase_date'];
                            tbody += "</td>";

                            tbody += "<td>";
                            if (currentItem['side'] == 'B') {
                                tbody += "Buy";
                            }
                            if (currentItem['side'] == 'S') {
                                tbody += "Sell";
                            }
                            tbody += "</td>";

                            tbody += "<td>";
                            tbody += currentItem['quantity'];
                            tbody += "</td>";

                            tbody += "<td>";
                            tbody += currentItem['price'];
                            tbody += "</td>";

                            tbody += "<td>";
                            tbody += currentItem['value'];
                            tbody += "</td>";

                            tbody += "</tr>";
                        }
                        $('#transactionHistory_tbody').html(tbody);
                        if (data['data']['links']) {
                            // Create Bootstrap-style pagination links
                            var linksHtml =
                                '<nav aria-label="Page navigation"><ul class="pagination">';
                            for (var j = 0; j < data['data']['links'].length; j++) {
                                var link = data['data']['links'][j];
                                var activeClass = link['active'] ? 'active' : '';
                                linksHtml += '<li class="page-item ' + activeClass +
                                    '"><a class="page-link" href="' +
                                    link['url'] + '">' + link['label'] + '</a></li>';
                            }
                            linksHtml += '</ul></nav>';
                            $('#transactionHistory_history_links').html(linksHtml);
                        } else {
                            // If 'links' property is not present, handle it accordingly
                            console.error('No pagination links found in the response.');
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                        $('#result').html(
                            '<span style="color: red;">Error occurred while fetching data.</span>'
                        );
                    }
                });
            });
        });
    </script>


    @if (session('message') == 'Buy order successful')
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: '{{ __('txt.buy_title') }}',
                    text: '{{ __('txt.buy_success') }}',
                    icon: 'success',
                    timer: 3000, // Auto close after 3 seconds
                    showConfirmButton: false
                });
            });
        </script>
    @endif
    @if (session('message') == 'Sell order successful')
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: '{{ __('txt.sell_title') }}',
                    text: '{{ __('txt.sell_success') }}',
                    icon: 'success',
                    timer: 3000, // Auto close after 3 seconds
                    showConfirmButton: false
                });
            });
        </script>
    @endif
@endsection
@endsection
