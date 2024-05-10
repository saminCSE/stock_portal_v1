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
<br>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="box-header with-border text-center">
                <h3 class="box-title">Index Value</h3>
            </div>
            <div class="card-body">

                {!! Form::open(['route' => ["dsedData.indexData"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'form_custom']) !!}

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
                    <table id="datatable" class="table table-bordered table-striped"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr class="success">
                            <th> SL.</th>
                            <th>Instrument Name</th>
                            <th>Capital Value</th>
                            <th>Deviation</th>
                            <th>Percentage Deviation</th>
                            <th>Date</th>
                            <th>Time</th>
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
                                <td>{{ $value->capital_value }}</td>
                                <td>{{ $value->deviation }}</td>
                                <td>{{ $value->percentage_deviation }}</td>
                                <td>{{ $value->index_date }}</td>
                                <td>{{ $value->index_time }}</td>
                                
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
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $(function () {
            $('.datepicker').datepicker({
                autoclose:true,
                todayHighlight:true,
                format:'yyyy-mm-dd',
            });

            
       
        });
    </script>

@endsection