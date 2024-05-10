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
        <div class="card ">
            <div class="card-body align-self-center">
                {!! Form::open(['route' => ["ipo.list"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'form_custom']) !!}
                <div class="row ">
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::label('From Date', ' From Date') !!}
                            {!! Form::text('from_date',$fromDate,['class'=>'form-control datepicker', 'placeholder'=>'From Date','required'=>'required']) !!}
                            {!! $errors->first('from_date', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::label('To Date', ' To Date') !!}
                            {!! Form::text('to_date', $toDate,['class'=>'form-control datepicker', 'placeholder'=>'To Date','required'=>'required']) !!}
                            {!! $errors->first('to_date', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-lg-2">
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
                    <table id="datatable" class="table table-bordered  nowrap"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th class="th-sm">SL</th>
                        <th class="th-sm">Ipo Name</th>
                        <th class="th-sm">Board Name</th>
                        <th class="th-sm">Asset Class</th>
                        <th class="th-sm">Listing Method</th>
                        <th class="th-sm">Status</th>
                        <th class="th-sm">Subscription Open date</th>
                        <th class="th-sm">Subscription Close date</th>
                        <th class="th-sm">IPO Size(BDT mn)</th>
                        <th class="th-sm">Offer Price</th>
                        <th class="th-sm">Summary</th>
                        <th class="th-sm">Prospectors </th>
                        <th class="th-sm">Results </th>
                        <th class="th-sm">Action</th>
                    </tr>
                </thead>

                <tbody>
                @php
                     $sr = ($ipo->currentpage()-1) * $ipo->perpage();
                 @endphp

                    @foreach($ipo as $key=>$list)
                    <tr>
                    <td>{{$sr + $key + 1 }}</td>
                        <td>{{$list->name}}</td>
                        <td>  @if($list->board==1)
                        <a  class="btn btn-sm ">MAIN</a>
                        @elseif($list->board==2)
                        <a  class="btn btn-sm ">SME</a>
                        @elseif($list->board==3)
                        <a  class="btn btn-sm ">ATB</a>
                        @endif</td>
                        <td>  @if($list->asset_class==1)
                        <a  class="btn btn-sm ">Equity</a>
                        @elseif($list->asset_class==2)
                        <a  class="btn btn-sm ">Debt (Bond)</a>
                        @elseif($list->asset_class==3)
                        <a  class="btn btn-sm ">Sukuk</a>
                        @endif</td>
                        <td>  @if($list->methods==1)
                        <a  class="btn btn-sm ">Direct listing</a>
                        @elseif($list->methods==2)
                        <a  class="btn btn-sm ">IPO</a>
                        @endif</td>

                        <td>  @if($list->status==1)
                        <a  class="btn btn-sm ">Applied </a>
                            @elseif($list->status==2)
                        <a  class="btn btn-sm">Approved</a>
                            @elseif($list->status==3)
                        <a  class="btn btn-sm ">Listing</a>
                            @elseif($list->status==4)
                        <a  class="btn btn-sm">Subscription</a>
                        @endif
                    </td>
                        <td>{{$list->Open_date}}</td>
                        <td>{{$list->close_date}}</td>
                        <td>{{$list->ipo_size}}</td>
                        <td>{{$list->offer_price}}</td>
                        <td>
                        <a href="{{route('ipo.summarydownload',['id'=>$list->id])}}">{{$list->summary}} <i class="fa fa-download" aria-hidden="true"></i>
                        </a>
                       </td>
                        <td>
                        <a href="{{route('ipo.prospectorsdownload',['id'=>$list->id])}}">{{$list->prospectors}} <i class="fa fa-download" aria-hidden="true"></i>
                        </a>
                    </td>
                        <td>
                        <a href="{{route('ipo.resultsdownload',['id'=>$list->id])}}">{{$list->results}}<i class="fa fa-download" aria-hidden="true"></i>
                        </a></td>
                        <td>
                            <a href="{{route('ipo.edit_ipo', ['id'=>$list->id])}}" class="btn btn-primary btn-sm btn-rounded editbtn">
                                <i class="fas fa-edit"></i></a>
                            <a href="{{route('ipo.ipo_delete', ['id'=>$list->id])}}" class="btn btn-danger btn-sm btn-rounded" onclick="return confirm('Are You sure To Delete this');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @if(!count($ipo))
                            <tr class="row1">
                                <td colspan="14" class="text-center"> No record found. </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="pagination_link">
                        {{ $ipo->links() }}
                    </div>
</div>
</div>
</div>
</div>
</div>
@endsection
@section('script')

<!-- <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script> -->
 <!-- <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script> -->
<!-- <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js')}}"></script> -->

<script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script>
    $(function() {
        $('.datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
        });
    });
</script>
@endsection
