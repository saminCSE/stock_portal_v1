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
                <div class="demo-nav row align-items-center">
                    <div class="left col-md-6 wow animate__fadeIn" data-wow-duration="3s">
                        <div>
                            <h4 class="m-0">{{ $broker_details ? $broker_details->portfolio_name : (session('applocale') === 'bn' ? $contest->title_bn : $contest->title) }}
                            </h4>
                            <p class="text-white m-0">{{ $broker_details ? $broker_details->broker_house_name : '' }}<i>
                                    {{ $broker_details ? '(' . $broker_details->branch_name . ' Branch)' : '' }}</i></p>
                        </div>

                    </div>

                    {{-- <div class="col-md-4">
                        <h5 class="text-white">Buying Power: {{ round($contest_profiles->balance, 2) }}</h5>
                    </div> --}}


                    <div class="right col-md-6 text-end wow animate__fadeIn" data-wow-duration="3s">
                        <a href="{{ route('demo.contest.panel', $contest->slug) }}"
                            class="btn btn-primary-outline">{{ __('txt.back_to_portfolio') }}</a>
                        {{-- <a href="{{route('demo.logout')}}" class="btn btn-primary-outline log_out">logout</a> --}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="buysell wow animate__fadeIn" data-wow-duration="3s">
                            <ul class="nav stock-nav-tabs mb-3" id="stockTab" role="tablist">
                                <li class="col-6 nav-item text-center" role="presentation">
                                    <a class="nav-link active" id="buy-tab" data-bs-toggle="tab" href="#buy"
                                        role="tab" aria-controls="buy"
                                        aria-selected="true">{{ __('txt.buy_order') }}</a>
                                </li>
                                <li class="col-6 nav-item text-center" role="presentation">
                                    <a class="nav-link" id="sell-tab" data-bs-toggle="tab" href="#sell" role="tab"
                                        aria-controls="sell" aria-selected="false">{{ __('txt.sell_order') }}</a>
                                </li>
                            </ul>


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

                            <div class="tab-content" id="stockTabContent">
                                <div class="tab-pane fade show active" id="buy" role="tabpanel"
                                    aria-labelledby="buy-tab">
                                    <form class="mt-4 buytradeform" method="post" action="{{ route('make_trade.buy') }}"
                                        id="buyForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="stockName"
                                                class="form-label">{{ __('txt.stock_name_symbol') }}</label>
                                            <input type="hidden" name="contests_id" value="{{ $contest->id }}">
                                            <select class="form-select select2buystock" id="stockName_buy"
                                                name="instrument_code" aria-label="{{ __('txt.select_stock') }}">
                                                <option value="" selected>{{ __('txt.select_stock') }}</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->instrument_code }}"
                                                        data-name="{{ $company->name }}"
                                                        data-category="{{ $company->sector_name }}">
                                                        {{ $company->instrument_code }}
                                                    </option>
                                                @endforeach
                                                <!-- Add more stock options as needed -->
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="buy_date" class="form-label">{{ __('txt.trade_date') }}</label>
                                                <input type="text" class="form-control" id="buy_date" placeholder=""
                                                    name="" value="{{ now()->format('Y-m-d') }}" readonly>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label for="stockQuantity"
                                                    class="form-label">{{ __('txt.stock_quantity') }}</label>
                                                <input type="number" class="form-control" id="stockQuantity_buy"
                                                    placeholder="{{ __('txt.enter_quantity') }}" name="quantity">
                                                <span id="quantity_error" style="color: red;"></span>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label for="stockPrice"
                                                    class="form-label">{{ __('txt.stock_price_bdt') }}</label>
                                                <input type="number" class="form-control" id="stockPrice_buy"
                                                    placeholder="{{ __('txt.stock_price_bdt') }}" readonly name="price"
                                                    readonly>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label for="stockPrice"
                                                    class="form-label">{{ __('txt.brokerage_share') }}</label>
                                                <input type="text" value="{{ $brokerage_fee }}%" class="form-control"
                                                    id="" placeholder="0.00" readonly>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label for="stockPrice"
                                                    class="form-label">{{ __('txt.cash_balance_bdt') }}</label>
                                                <input type="number" class="form-control" id=""
                                                    value="{{ round($contest_profiles->balance, 2) }}" readonly>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label for="stockPrice" class="form-label">{{ __('txt.total') }}</label>
                                                <input type="number" class="form-control"
                                                    placeholder="{{ __('txt.total') }}" value=""
                                                    id="buy_total_cost_form" readonly>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col">
                                                <h6>{{ __('txt.total_cost') }}</h6>
                                            </div>
                                            <div class="col">
                                                <h6 class="text-end" id="buy_total_cost">BDT 00.00</h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <h6>{{ __('txt.brokerage_fee') }}</h6>
                                            </div>
                                            <div class="col">
                                                <h6 class="text-end" id="buy_brokerage_fee">BDT 00.00</h6>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col">
                                                <h6>{{ __('txt.grand_total') }}</h6>
                                            </div>
                                            <div class="col">
                                                <h6 class="text-end" id="buy_grand_total">BDT 00.00</h6>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="mb-3 row">
                                            <div class="col-md-6 offset-md-3">
                                                <input type="submit" class="form-control bg-success text-white"
                                                    style="background-color: #043b70 !important;" id="buyButton"
                                                    value="{{ __('txt.buy') }}">
                                            </div>
                                        </div>
                                    </form>

                                </div>


                                <div class="tab-pane fade" id="sell" role="tabpanel" aria-labelledby="sell-tab">
                                    <form class="mt-4 selltradeform" method="post"
                                        action="{{ route('make_trade.sell') }}" id="sellForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="stockName"
                                                class="form-label">{{ __('txt.stock_name_symbol') }}</label><br>
                                            <input type="hidden" name="contests_id" value="{{ $contest->id }}"
                                                style="display: none">
                                            <select class="form-select select2sellstock" id="stockName_sell"
                                                aria-label="{{ __('txt.select_stock') }}" name="instrument_code">
                                                <option value="" selected>{{ __('txt.select_stock') }}</option>
                                                @foreach ($saleableSymbols as $saleableSymbol)
                                                    <option value="{{ $saleableSymbol->instrument_code }}"
                                                        data-name="{{ $saleableSymbol->name }}"
                                                        data-category="{{ $saleableSymbol->sector_name }}">
                                                        {{ $saleableSymbol->instrument_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="sell_date"
                                                    class="form-label">{{ __('txt.trade_date') }}</label>
                                                <input type="text" class="form-control" id="sell_date" placeholder=""
                                                    name="" value="{{ now()->format('Y-m-d') }}" readonly>
                                                <span id="quantity_error" style="color: red;"></span>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label for="stockQuantity"
                                                    class="form-label">{{ __('txt.stock_quantity') }}</label>
                                                <input type="number" class="form-control" id="stockQuantity_sell"
                                                    placeholder="{{ __('txt.enter_quantity') }}" name="quantity">
                                                <span id="quantity_error" style="color: red;"></span>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label for="stockPrice"
                                                    class="form-label">{{ __('txt.stock_price_bdt') }}</label>
                                                <input type="number" class="form-control" id="stockPrice_sell"
                                                    placeholder="{{ __('txt.stock_price_bdt') }}" readonly name="price"
                                                    readonly>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label for="stockPrice"
                                                    class="form-label">{{ __('txt.brokerage_share_bdt') }}</label>
                                                <input type="text" class="form-control" id=""
                                                    value="{{ $brokerage_fee }}%" placeholder="0.00" readonly>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label for="stockPrice"
                                                    class="form-label">{{ __('txt.saleable_quantity') }}</label>
                                                <input type="number" class="form-control" id="saleable_quantity"
                                                    value="0" readonly>
                                            </div>

                                            <div class="col-6 mb-3">
                                                <label for="stockPrice" class="form-label">{{ __('txt.total') }}</label>
                                                <input type="number" class="form-control"
                                                    placeholder="{{ __('txt.total') }}" value=""
                                                    id="sell_total_cost_form" readonly>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col">
                                                <h6>{{ __('txt.total_cost') }}</h6>
                                            </div>
                                            <div class="col">
                                                <h6 class="text-end" id="sell_total_cost">BDT 00.00</h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <h6>{{ __('txt.brokerage_fee') }}</h6>
                                            </div>
                                            <div class="col">
                                                <h6 class="text-end" id="sell_brokerage_fee">BDT 00.00</h6>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col">
                                                <h6>{{ __('txt.grand_total') }}</h6>
                                            </div>
                                            <div class="col">
                                                <h6 class="text-end" id="sell_grand_total">BDT 00.00</h6>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="mb-3 row">
                                            <div class="col-md-6 offset-md-3">
                                                <input type="submit" class="form-control bg-success text-white"
                                                    style="background-color: #043b70 !important;" id="sellButton"
                                                    value="{{ __('txt.sell') }}">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    {{-- ===================Start Buy Section ============================== --}}
    <script>
        $(document).ready(function() {
            $('#stockName_buy').on('change', function() {
                var selectedStock = $(this).val();
                console.log(selectedStock);
                $.ajax({
                    url: '{{ route('lastTradePrice') }}',
                    method: 'POST',
                    data: {
                        stock: selectedStock,
                        contests_id: {{ $contest->id }},
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#stockPrice_buy').val(parseFloat(data.lastTradePrice).toFixed(2));
                        $('#lastBalance').val(parseFloat(data.lastBalance).toFixed(2));

                        $('#stockQuantity_buy').val("");
                        $('#buy_cost').text('BDT 00.00');
                        $('#buy_total_cost').text('BDT 00.00');
                        $('#buy_total_cost_form').val('BDT 00.00');
                        $('#buy_brokerage_fee').text('BDT 00.00');
                        $('#buy_grand_total').text('BDT 00.00');

                        // var maxQuantity = data.lastBalance / data.lastTradePrice;
                        // var maxQuantity = Math.floor(data.lastBalance / data.lastTradePrice);

                        // $('#stockQuantity_buy').attr('max', maxQuantity);

                    },
                    error: function(xhr, status, error) {}
                });
            });
        });
    </script>

    {{-- <script>
        document.getElementById('stockQuantity_buy').addEventListener('input', function() {
                    if (this.value > this.max) {
                        this.value = this.max;
                    }
                });
    </script> --}}

    <script>
        $(document).ready(function() {
            $('#stockName_buy').on('change', function() {
                updateCostAndTotal();
            });

            $('#stockQuantity_buy, #stockPrice_buy').on('input', function() {
                updateCostAndTotal();
            });

            function updateCostAndTotal() {
                var stockQuantity = parseFloat($('#stockQuantity_buy').val());
                var stockPrice = parseFloat($('#stockPrice_buy').val());

                if (isNaN(stockQuantity) || isNaN(stockPrice)) {
                    return; // Do nothing if the input is not a valid number
                }

                var cost = stockQuantity * stockPrice;
                var totalCost = cost;
                var fee = {{ $brokerage_fee }} * totalCost / 100;
                var grandtotal = totalCost + fee;



                $('#buy_cost').text('BDT ' + cost.toFixed(2));
                $('#buy_total_cost').text('BDT ' + totalCost.toFixed(2));
                $('#buy_total_cost_form').val(totalCost.toFixed(2));
                $('#buy_brokerage_fee').text('BDT ' + fee.toFixed(2));
                $('#buy_grand_total').text('BDT ' + grandtotal.toFixed(2));
            }

        });
    </script>

    {{-- ===================End Buy Section ============================== --}}



    {{-- ===================Start Sell Section ============================== --}}

    <script>
        $(document).ready(function() {
            $('#stockName_sell').on('change', function() {
                var selectedStock = $(this).val();
                console.log(selectedStock);
                $.ajax({
                    url: '{{ route('lastTradePrice') }}',
                    method: 'POST',
                    data: {
                        stock: selectedStock,
                        contests_id: {{ $contest->id }},
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        console.log(data);
                        $('#stockPrice_sell').val(parseFloat(data.lastTradePrice).toFixed(2));
                        $('#saleable_quantity').val(data.saleable_quantity);
                        $('#stockQuantity_sell').val(data.saleable_quantity);
                        $('#lastBalance').val(parseFloat(data.lastBalance).toFixed(2));
                        $('#sell_cost').text('BDT 00.00');
                        $('#sell_total_cost').text('BDT 00.00');
                        $('#sell_total_cost_form').val('BDT 00.00');
                        $('#sell_brokerage_fee').text('BDT 00.00');
                        $('#sell_grand_total').text('BDT 00.00');
                    },
                    error: function(xhr, status, error) {}
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#stockName_sell').on('change', function() {
                updateCostAndTotal();
            });

            $('#stockQuantity_sell, #stockPrice_sell').on('input', function() {
                updateCostAndTotal();
            });

            function updateCostAndTotal() {
                var stockQuantity = parseFloat($('#stockQuantity_sell').val());
                var stockPrice = parseFloat($('#stockPrice_sell').val());

                if (isNaN(stockQuantity) || isNaN(stockPrice)) {
                    return; // Do nothing if the input is not a valid number
                }

                var cost = stockQuantity * stockPrice;
                var totalCost = cost;
                var fee = {{ $brokerage_fee }} * totalCost / 100;
                var grandtotal = totalCost - fee;

                $('#sell_cost').text('BDT ' + cost.toFixed(2));
                $('#sell_total_cost').text('BDT ' + totalCost.toFixed(2));
                $('#sell_total_cost_form').val(totalCost.toFixed(2));
                $('#sell_brokerage_fee').text('BDT ' + fee.toFixed(2));
                $('#sell_grand_total').text('BDT ' + grandtotal.toFixed(2));
            }
        });
    </script>
    <script>
        // Add JavaScript to handle alert dismissal
        $(document).ready(function() {
            $(".alert .close").on('click', function() {
                $(this).parent().fadeOut(300);
            });
        });
    </script>
    {{-- ===================End Sell Section ============================== --}}

    {{-- =================== Buy Section ============================== --}}
    <script>
        document.getElementById('buyButton').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '{{ __('txt.confirm_buy_title') }}',
                text: '{{ __('txt.confirm_buy_text') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __('txt.confirm_buy_button') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform the action to buy the item here
                    $("#buyForm").submit();
                    // Swal.fire('Buy!', 'Your item has been bought.', 'success');
                }
            });
        });
    </script>

    {{-- =================== Sell Section ============================== --}}
    <script>
        document.getElementById('sellButton').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '{{ __('txt.confirm_sell_title') }}',
                text: '{{ __('txt.confirm_sell_text') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __('txt.confirm_sell_button') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform the action to sell the item here
                    $("#sellForm").submit();
                    // Swal.fire('Sold!', 'Your item has been sold.', 'success');
                }
            });
        });


        // <script>
        //     $(document).ready(function() {
        //     $('#stockName_buy').change(function() {
        //         var selectedValue = $(this).val();
        //         if (selectedValue !== '') {
        //             // If a stock is selected, enable the quantity input field
        //             $('#stockQuantity_buy').prop('readonly', false);
        //         } else {
        //             // If no stock is selected, disable the quantity input field
        //             $('#stockQuantity_buy').prop('readonly', true);
        //         }
        //     });
        // });
        //
    </script>

    @if (session('buyerror') == 'Insufficient balance')
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: '{{ __('txt.error_title') }}',
                    text: '{{ __('txt.insufficient_balance_error') }}',
                    icon: 'error',
                    timer: 3000, // Auto close after 3 seconds
                    showConfirmButton: false
                });
            });
        </script>
    @endif
    @if (session('sellerror') == 'Insufficient quantity')
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: '{{ __('txt.error_title') }}',
                    text: '{{ __('txt.insufficient_quantity_error') }}',
                    icon: 'error',
                    timer: 3000, // Auto close after 3 seconds
                    showConfirmButton: false
                });
            });
        </script>
    @endif


@endsection
