@extends('layouts.master')

@section('css')
<!-- datatables css -->
<!-- <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/> -->
<link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />

<style>
    table,
    td,
    th {
        vertical-align: middle !important;
    }

    table th {
        font-weight: bold;
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                {!! Form::open(['route' => ["announce_list"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'form_custom']) !!}

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
<div class="card shadow mb-12">
    @if (session('status'))
    <div class="alert alert-success">{{ session('status')}}</div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="th-sm">ID</th>
                                <th class="th-sm">Market</th>
                                <th class="th-sm">Instrument Name</th>
                                <th class="th-sm">Prefix</th>
                                <th class="th-sm">Title</th>
                                <th class="th-sm">Details</th>
                                <th class="th-sm">Post Date</th>
                                <th class="th-sm">Expire Date</th>
                                <th class="th-sm">Status</th>
                                <th class="th-sm">Updated</th>
                                <th class="th-sm">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $sr = ($announce->currentpage()-1) * $announce->perpage();
                            @endphp

                            @foreach($announce as $key=>$list)
                            <tr>
                                <td> {{ $sr + $key + 1 }} </td>
                                <td>{{$list->market_id}}</td>
                                <td>{{$list->instruments_name }}</td>
                                <td>{{$list->prefix}}</td>
                                <td>{{$list->title}}</td>
                                <td>{{ Str::limit($list->details, 50) }}</td>
                                <td>{{$list->post_date}}</td>
                                <td>{{$list->expire_date}}</td>
                                <td> @if($list->is_active==1)
                                    <a class="btn btn-sm btn-success text-white ">Active</a>
                                    @elseif($list->is_active==0)
                                    <a class="btn btn-sm btn-danger text-white">Deactive</a>
                                    @endif
                                </td>
                                <td>{{$list->updated}}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm btn-rounded viewbtn" value="{{$list->id}}">
                                        <i class="fas fa-eye"></i></button>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if(!count($announce))
                            <tr class="row1">
                                <td colspan="8" class="text-center"> No record found. </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="pagination_link">
                        {{ $announce->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="announcerModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                        <tr >
                            <th class="th-sm">Market</th>
                                <td id="market_id"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">Instrument Name</th>
                        <td id="instruments_name"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">Prefix</th>
                        <td id="prefix"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">Title</th>
                        <td id="title"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">Details</th>
                        <td id="details"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">Post Date</th>
                        <td id="post_date"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">Expire Date</th>
                        <td id="expire_date"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">Status</th>
                        <td id="is_active"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">Updated</th>
                        <td id="updated"></td>
                    </tr>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<!-- Plugins js -->
<!-- <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
<script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js')}}"></script> -->
<script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script>
    $(document).on('click', '.viewbtn', function(e) {
        e.preventDefault();
        var id = $(this).val();
        console.log(id);
        $('#announcerModal').modal('show');
        $.ajax({
            type: "get",
            url: "{{url(config('siteconfig.adminRoute').'/announcement/details')}}/" + id,
            success: function(response) {
                if (response.status == 404) {
                    $("#success_message").html("");
                    $("#success_message").addClass('alert alert-danger');
                    $("#success_message").text(response.message);
                } else {
                    var status ="Deactive";
                    if(response.announce.is_active == 1){
                        status ="Active";
                    }
                    $('#market_id').html(response.announce.market_id)
                    $('#instruments_name').html(response.announce.instruments_name)
                    $('#prefix').html(response.announce.prefix)
                    $('#title').html(response.announce.title)
                    $('#details').html(response.announce.details)
                    $('#post_date').html(response.announce.post_date)
                    $('#expire_date').html(response.announce.expire_date)
                    $('#is_active').html(status)
                    $('#updated').html(response.announce.updated)
                }
            }
        });
    });
    $(function() {
        $('.datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
        });
    });
</script>

@endsection