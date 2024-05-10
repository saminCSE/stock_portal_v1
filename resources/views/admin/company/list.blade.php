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

                {!! Form::open(['route' => ["company_list"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'form_custom']) !!}
                <div class="row ">
                    <div class="col-lg-3">
                        <div class="form-group">
                            {!! Form::label('code',' Code') !!}
                            {!! Form::select('code', $companys,$company_id,['class'=>'form-control select2']) !!}
                            {!! $errors->first('code', '<p class="help-block text-danger">:message</p>') !!}
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                            <tr>
                                <th class="th-sm">SL.</th>
                                <th class="th-sm">Company name</th>
                                <th class="th-sm">Code Name</th>
                                <th class="th-sm">Trading Code</th>
                                <th class="th-sm">Instrument Code</th>
                                <th class="th-sm">Instrument Id</th>
                                <th class="th-sm">Scip Code</th>

                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $sr = ($company->currentpage()-1) * $company->perpage();
                            @endphp     
                            @foreach($company as $list)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td>{{$list->name}}</td>
                                <td>{{$list->code}}</td>
                                <td>{{$list->xcode}}</td>
                                <td>{{$list->Instruments_code }}</td>
                                <td>{{$list->Instruments_id}}</td>
                                <td>{{$list->symbol}}</td>
                            </tr>
                            @endforeach
                            @if(!count($company))
                            <tr class="row1">
                                <td colspan="8" class="text-center"> No record found. </td>
                            </tr>

                            @endif
                        </tbody>
                    </table>
                    <div class="pagination_link">
                        {{ $company->links() }}
                    </div>
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