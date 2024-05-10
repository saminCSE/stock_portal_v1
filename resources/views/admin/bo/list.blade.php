@extends('layouts.master')

@section('css')
    <!-- datatables css -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="card shadow mb-12">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status')}}</div>
        @endif
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <h1 class="text-center mt-4">Benificiary Owners</h1>
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th class="th-sm">SL</th>
                                <th class="th-sm">BO Name</th>
                                <th class="th-sm">Email</th>
                                <th class="th-sm">Phone</th>
                                <th class="th-sm">Download profile</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($bos as $bo)
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$bo->name}}</td>
                                    <td>{{$bo->email}}</td>
                                    <td>{{$bo->mobile}}</td>
                                    <td>
                                        <a class="btn btn-success" href="{{route('generatepdf',$bo->id)}}"><i  class="ti-download"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endsection
