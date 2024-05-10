@extends('layouts.master')

@section('css')
    <!-- datatables css -->
    <!-- <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/> -->

    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet"
          type="text/css"/>

    <style>

        table, td, th {
            vertical-align: middle !important;
         }
         table th {
            font-weight: bold;
         }
         .card {
          width: 630px;
}

    </style>
@endsection

@section('content')
<br>
<div class="row">
    <div class="col-12">
        <div class="card">


            <div class="box-header with-border text-center">
                <h3 class="box-title">Daily Data Information</h3>
            </div>
            <div class="card-body">

                {!! Form::open(['route' => ["dsedData.mkistat"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}

                <div class="row ">
                    <div class="col-lg-4">
                        <div class="form-group">
                            {!! Form::label('From Date', ' From Date') !!}
                            {!! Form::text('from_date',$fromDate,['class'=>'form-control datepicker', 'placeholder'=>'From Date','required'=>'required']) !!}
                            {!! $errors->first('from_date', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            {!! Form::label('To Date', ' To Date') !!}
                            {!! Form::text('to_date', $toDate,['class'=>'form-control datepicker', 'placeholder'=>'To Date','required'=>'required']) !!}
                            {!! $errors->first('to_date', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                   
                   
                    <div class="col-lg-4">
                        <div class="form-group">
                            <div style="margin-top: 30px;">
                                <button type="submit" id="btn_search" class="btn btn-primary waves-effect waves-light mr-1">
                                    Search
                                </button>

                            </div>
                        </div>
                    </div>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table  class="table table-bordered table-responsive table-striped"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr class="success">
                            <th> SL.</th>
                            <th>Market instrument's Trading Code</th>
                            <th>Market Instrument's Number</th>
                            <th>Market Instrument's group</th>
                            <th>Opening Price for the instrument for the day</th>
                            <th>Last Traded Price for the Instrument for the day in public market</th>
                            <th>Last Traded Price for the Instrument for the day in spot market</th>
                            <th>High Price for the Instrument for the day</th>
                            <th>Low Price for the instrument for the day</th>
                            <th>Closing Price for the Instrument for the day</th>
                            <th>Yesterday's Closing Price for the Instrument</th>
                            <th>Total Number of Trades for the Instrument</th>
                            <th>Total Quantity traded for the Instrument</th>
                            <th>Total Traded Value for the Instrument (in millions)</th>
                            <th>Total Number of Trades for the Instrument in public market</th>
                            <th>Total Quantity traded for the Instrument in public market</th>
                            <th>Total Traded Value for the Instrument in public market (in millions)</th>
                            <th>Total Number of Trades for the Instrument in spot market</th>
                            <th>Total Quantity traded for the Instrument in spot market</th>
                            <th>Total Traded Value for the Instrument in spot market (in millions)</th>
                            <th>Last Modified Timestamp</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                          
                           
                        </tr>
                        </thead>


                        <tbody id="tablecontents">

                      
                        @foreach($collections as $key=>$value)
                       

                            <tr class="row1">
                               
                                <td> {{ $key+1 }} </td>
                                <td>{{ $value->instrument_id }}</td>
                                <td>{{ $value->quote_bases }}</td>
                                <td>{{ $value->open_price }}</td>
                                <td>{{ $value->pub_last_traded_price }}</td>
                                <td>{{ $value->spot_last_traded_price }}</td>
                                <td>{{ $value->high_price }}</td>
                                <td>{{ $value->low_price }}</td>
                                <td>{{ $value->close_price }}</td>
                                <td>{{ $value->yday_close_price }}</td>
                                <td>{{ $value->total_trades }}</td>
                                <td>{{ $value->total_volume }}</td>
                                <td>{{ $value->new_volume }}</td>
                                <td>{{ $value->total_value }}</td>
                                <td>{{ $value->public_total_trades }}</td>
                                <td>{{ $value->public_total_volume }}</td>
                                <td>{{ $value->public_total_value }}</td>
                                <td>{{ $value->spot_total_trades }}</td>
                                <td>{{ $value->spot_total_volume }}</td>
                                <td>{{ $value->spot_total_value }}</td>
                                <td>{{ $value->lm_date_time }}</td>
                                <td>{{ $value->trade_time }}</td>
                                
                                <td>{{ $value->created_at }}</td>
                                <td>{{ $value->updated_at }}</td>
                                
                                
                            </tr>
                        @endforeach
                        
                        
                        </tbody>
                    </table>
                    <div class="pagination_link">
                        {{ $collections->links() }}


                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection

@section('script')

    <!-- Plugins js -->
    <!-- <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js')}}"></script> -->
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $(function () {
            $('.datepicker').datepicker({
                autoclose:true,
                todayHighlight:true,
                format:'yyyy-mm-dd',
            });

            // function sendOrderToServer() {
            //     var order = [];
            //     $('tr.row1').each(function (index, element) {
            //         order.push({
            //             id: $(this).attr('data-id'),
            //             position: index + 1
            //         });
            //     });

            //     $.ajax({
            //         type: "POST",
            //         dataType: "json",
            //         url: "",
            //         data: {
            //             order: order,
            //             _token: '{{csrf_token()}}'
            //         },
            //         success: function (response) {
            //             if (response == "Update Successfully.") {
            //                 location.reload();
            //             } else {
            //                 console.log(response);
            //             }
            //         }
            //     });

            // }
        });
    </script>

@endsection