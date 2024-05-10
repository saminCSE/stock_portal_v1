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

<div class="card shadow mb-12">
@if (session('status'))
    <div class="alert alert-success">{{ session('status')}}</div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="box-header with-border text-center">
                <h3 class="box-title">Company AGM List</h3>
            </div>
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="th-sm">SL.</th>
                                <th class="th-sm">Company name</th>
                                <th class="th-sm">Last Agm HeldOn</th>
                                <th class="th-sm">Right Issue</th>
                                <th class="th-sm">Year End</th>
                                <th class="th-sm">Reserve Surplus</th>
                                <th class="th-sm">Comprehensive Income</th>
                                <th class="th-sm"> Action</th>
                            </tr>
                        </thead>

                        <tbody>
                   
                            @foreach($agm_info as $list)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td>{{$list->company_name}}</td>
                                <td>{{$list->last_agm_held_on}}</td>
                                <td>{{$list->right_issue}}</td>
                                <td>{{$list->year_end}}</td>
                                <td>{{$list->reserve_surplus}}</td>
                                <td>{{$list->comprehensive_income}}</td>
                                <td>
                                <a href="{{url(config('siteconfig.adminRoute').'/company_agm/'.$list->agmid.'/edit')}}" class="btn btn-primary btn-sm btn-rounded editbtn">
                                <i class="fas fa-edit"></i></a>

                                {!! Form::open(['route' => ["company_agm.destroy",$list->agmid], 'method'=>'delete',  'style'=>'display:inline']) !!}
                                    <button class="btn btn-danger btn-xs text-white" data-toggle="tooltip"
                                            title="Delete"
                                            style="display:inline;padding:2px 5px 3px 5px;"
                                            onclick="return confirm('Are you sure to delete this?')"><i
                                                class="fas fa-times"></i>
                                    </button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            @endforeach
                            @if(!count($agm_info))
                            <tr class="row1">
                                <td colspan="8" class="text-center"> No record found. </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
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

@endsection