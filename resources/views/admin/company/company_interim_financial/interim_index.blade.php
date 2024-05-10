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
@if (session('status'))
    <div class="alert alert-success">{{ session('status')}}</div>
    @endif
<div class="card shadow mb-12">
    <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="box-header with-border text-center">
                <h3 class="box-title">Company Interim Financial</h3>
            </div>
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="th-sm">SL.</th>
                                <th class="th-sm">Company name</th>
                                <th class="th-sm">Turnover</th>
                                <th class="th-sm">PFCO</th>
                                <th class="th-sm">pftp</th>
                                <th class="th-sm">tcip</th>
                                <th class="th-sm">basic_eps</th>
                                <th class="th-sm">diluted_eps</th>
                                <th class="th-sm">basic_epsco</th>
                                <th class="th-sm">diluted_epsco</th>
                                <th class="th-sm">mppspe</th>
                                <th class="th-sm">half_yearly</th>
                                <th class="th-sm">annual</th>
                                <th class="th-sm"> Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $sr = ($interim->currentpage()-1) * $interim->perpage();
                            @endphp
                            @foreach($interim as $list)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td>{{$list->company_name}}</td>
                                <td>{{$list->turnover}}</td>
                                <td>{{$list->pfco}}</td>
                                <td>{{$list->pftp}}</td>
                                <td>{{$list->tcip}}</td>
                                <td>{{$list->basic_eps}}</td>
                                <td>{{$list->diluted_eps}}</td>
                                <td>{{$list->basic_epsco}}</td>
                                <td>{{$list->diluted_epsco}}</td>
                                <td>{{$list->mppspe}}</td>
                                <td>{{$list->half_yearly}}</td>
                                <td>{{$list->annual}}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm btn-rounded viewbtn" value="{{$list->interimid}}">
                                        <i class="fas fa-eye"></i></button>
                                        <br/>
                                        <br/>
                                        <a href="{{url(config('siteconfig.adminRoute').'/company_interim/'.$list->interimid.'/edit')}}" class="btn btn-primary btn-sm btn-rounded">
                                <i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @if(!count($interim))
                            <tr class="row1">
                                <td colspan="8" class="text-center"> No record found. </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="pagination_link">
                        {{ $interim->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" id="CompanyInterimModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <div class="text-center">
            <h2>Company Interim Financial Information</h2>
        </div>  
        <br/>
            <thead>
                        <tr >
                            <th class="th-sm">Company name</th>
                                <td id="company_name"></td>
                        </tr>
                        <tr >
                            <th class="th-sm">turnover</th>
                                <td id="turnover"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">pfco</th>
                        <td id="pfco"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">pftp</th>
                        <td id="pftp"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">tcip</th>
                        <td id="tcip"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">basic_eps</th>
                        <td id="basic_eps"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">diluted_eps</th>
                        <td id="diluted_eps"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">basic_epsco</th>
                        <td id="basic_epsco"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">diluted_epsco</th>
                        <td id="diluted_epsco"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">mppspe</th>
                        <td id="mppspe"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">q1</th>
                        <td id="q1"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">q2</th>
                        <td id="q2"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">half_yearly</th>
                        <td id="half_yearly"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">q3</th>
                        <td id="q3"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">nine_months</th>
                        <td id="nine_months"></td>
                        </tr>
                        <tr>
                        <th class="th-sm">annual</th>
                        <td id="annual"></td>
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
        $('#CompanyInterimModal').modal('show');
        $.ajax({
            type: "get",
            url: "{{url(config('siteconfig.adminRoute').'/company_interim/details')}}/" + id,
            success: function(response) {
                if (response.status == 404) {
                    $("#success_message").html("");
                    $("#success_message").addClass('alert alert-danger');
                    $("#success_message").text(response.message);
                } else {
                    $('#company_name').html(response.interim.company_name)
                    $('#turnover').html(response.interim.turnover)
                    $('#pfco').html(response.interim.pfco)
                    $('#pftp').html(response.interim.pftp)
                    $('#tcip').html(response.interim.tcip)
                    $('#basic_eps').html(response.interim.basic_eps)
                    $('#diluted_eps').html(response.interim.diluted_eps)
                    $('#basic_epsco').html(response.interim.basic_epsco)
                    $('#diluted_epsco').html(response.interim.diluted_epsco)
                    $('#mppspe').html(response.interim.mppspe)
                    $('#q1').html(response.interim.q1)
                    $('#q2').html(response.interim.q2)
                    $('#half_yearly').html(response.interim.half_yearly)
                    $('#q3').html(response.interim.q3)
                    $('#nine_months').html(response.interim.nine_months)
                    $('#annual').html(response.interim.annual)
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