@extends('layouts.master')

@section('css')
    <!-- datatables css -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<br>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr class="success">
                            <th> SL.</th>
                            <th>Trading Date</th>
                            <th>Trading Time</th>
                            <th>Trading Close</th>
                            <th>Status</th>
                            <th>Comments</th>
                            <th>Action</th>

                        </tr>
                        </thead>


                        <tbody id="tablecontents">


                        @foreach($collections as $key=>$value)
                            @php
                                $id = $value->id;
                            @endphp

                            <tr class="row1" data-id="{{ $id }}">

                                <td> {{ $key+1 }} </td>

                                <td> {{ $value->open_date }} </td>
                                <td> {{ $value->open_time }} </td>
                                <td> {{ $value->close_time }} </td>
                                <td>
                                    @if($value->status == 1)
                                        <span class="text-success">Open </span>
                                    @else
                                        <span class="text-danger">Closed </span>
                                    @endif
                                </td>
                                <td> {{ $value->comments }} </td>
                                <td>
                                <a href="{{route('ChangeMarketSchedulerdata.edit',['id'=>$value->id])}}" class="btn btn-primary btn-sm btn-rounded editbtn">
                                <i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection

@section('script')

    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js')}}"></script>

    <script>
        $(function () {

$("#pagetopaddaction").hide();

        });
    </script>

@endsection
