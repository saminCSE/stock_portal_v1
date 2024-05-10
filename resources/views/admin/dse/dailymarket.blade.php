@extends('layouts.master')

@section('css')
    <!-- datatables css -->
    <!-- <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/> -->
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet"
          type="text/css"/>

    <style>

        table, td, th {
            vertical-align: middle !important;
         }
         table th {
            font-weight: bold;
         }

    </style>
@endsection

@section('content')
@if (session('status'))
<div class="alert alert-success">{{ session('status')}}</div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="box-header with-border text-center">
                <h3 class="box-title">Today Data</h3>
            </div>
            <div class="card-body">

                {!! Form::open(['route' => ["dsedData.intradata"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'form_custom']) !!}

                <div class="row ">
                    <div class="col-lg-3">
                        <div class="form-group">
                            {!! Form::label('From Date', ' From Date') !!}
                            {!! Form::text('from_date',$fromDate,['class'=>'form-control datepicker', 'placeholder'=>'From Date','required'=>'required']) !!}
                            {!! $errors->first('from_date', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            {!! Form::label('To Date', ' To Date') !!}
                            {!! Form::text('to_date', $toDate,['class'=>'form-control datepicker', 'placeholder'=>'To Date','required'=>'required']) !!}
                            {!! $errors->first('to_date', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            {!! Form::label('instrument_id', ' Instrument') !!}
                            {!! Form::select('instrument_id', $instruments,$instrument_id,['class'=>'form-control select2']) !!}
                            {!! $errors->first('instrument_id', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                          
                    <div class="col-lg-3">
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
                    <table  class="table table-bordered table-striped"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr class="success">
                            <th> SL.</th>
                            <th>Instrument Name</th>
                            <th>Date</th>
                            <th>Trade Time</th>
                            <th>Open Price</th>
                            <th>Last Trade price</th>
                            <th>High Price</th>
                            <th>Low Price</th>
                            <th>Close Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>


                        <tbody id="tablecontents">

                        @php 
                            $sr = ($collections->currentpage()-1) * $collections->perpage();
                        @endphp

                        @foreach($collections as $key=>$value)
                       

                            <tr class="row1">
                               
                                <td> {{ $sr + $key + 1 }} </td>
                                <td>{{ $value->instrument ?$value->instrument->instrument_code:'' }}</td>
                                <td>{{ $value->trade_date }}</td>
                                <td>{{ $value->trade_time }}</td>
                                <td>{{ $value->open_price }}</td>
                                <td>{{ $value->pub_last_traded_price }}</td>
                                <td>{{ $value->high_price }}</td>
                                <td>{{ $value->low_price }}</td>
                                <td>{{ $value->close_price }}</td>
                                <td>    
                                <a href="{{route('dailyData.edit_dailyData', ['id'=>$value->id])}}" class="btn btn-primary btn-sm btn-rounded editbtn">
                                <i class="fas fa-edit"></i>

                                <a href="{{route('dailyData.dailyData_delete', ['id'=>$value->id])}}" class="btn btn-primary btn-sm btn-rounded">
                                <i class="fas fa-trash"></i>
                            </a>
                            </td>
                            </tr>
                        @endforeach

                        @if(!count($collections)) 
                            <tr class="row1">
                                <td colspan="8" class="text-center"> No record found. </td>
                               
                            </tr>
                        
                        @endif
                        
                        
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