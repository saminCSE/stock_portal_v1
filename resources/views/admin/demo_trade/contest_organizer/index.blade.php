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
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                            <th class="th-sm">SL</th>
                                <th class="th-sm">Name</th>
                                <th class="th-sm">Contest Name</th>
                                <th class="th-sm">Email</th>
                                <th class="th-sm">Phone Number</th>
                                <th class="th-sm">Status</th>
                                <th class="th-sm">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($contestOrganizers as $contestOrganizer)
                                <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$contestOrganizer->name}}</td>
                                    <td>{{$contestOrganizer->contest_title}}</td>
                                    <td>{{$contestOrganizer->email}}</td>
                                    <td>{{$contestOrganizer->phone}}</td>
                                    <td class="{{$contestOrganizer->is_active == 1 ? 'text-success' : 'text-danger'}}">{{$contestOrganizer->is_active == 1 ? 'Active' : 'Inactive'}}</td>
                                    <td>
                                        <a href="{{url(config('siteconfig.adminRoute').'/contest_organizer/'.$contestOrganizer->id.'/edit')}}" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>

                                        {!! Form::open(['route' => ["contest_organizer.destroy",$contestOrganizer->id], 'method'=>'delete', 'style'=>'display:inline']) !!}
                                        <button class="btn btn-danger btn-xs text-white" data-toggle="tooltip" title="Delete" style="display:inline;padding:2px 5px 3px 5px;" onclick="return confirm('Are you sure to delete this?')"><i class="fas fa-times"></i>
                                        </button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
{{--                                @if(!count($announce))--}}
{{--                                    <tr class="row1">--}}
{{--                                        <td colspan="8" class="text-center"> No record found. </td>--}}

{{--                                    </tr>--}}

{{--                                @endif--}}
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



