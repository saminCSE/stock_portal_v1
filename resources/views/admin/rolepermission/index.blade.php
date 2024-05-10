@extends('layouts.master')

@section('css')
    <!-- datatables css -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr class="success">
                            <th> SL.</th>
                            <th>Role Name</th>
                           
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>


                        <tbody id="tablecontents">

                      
                        @foreach($collections as $key=>$value)
                            @php
                                $id = $value->id;
                            @endphp

                            <tr class="row1" data-id="{{ $id }}">
                               
                                <td>{{ $key+1 }}</td>
                            
                                <td>{{ $value->role?$value->role->name:'' }}</td>
                               
                                <td class="text-center">

                                 @if(Auth()->user()->can('permissionrole edit')) 
                                    <a href="{{url(config('siteconfig.adminRoute').'/permissionrole/'.$value->role_id.'/edit')}}"
                                       class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                                       style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>

                                 @endif

                                 @if(Auth()->user()->can('permissionrole delete'))
                                    {!! Form::open(['route' => ["permissionrole.destroy",$value->role_id], 'method'=>'delete',  'style'=>'display:inline']) !!}
                                    <button class="btn btn-danger btn-xs text-white" data-toggle="tooltip"
                                            title="Delete"
                                            style="display:inline;padding:2px 5px 3px 5px;"
                                            onclick="return confirm('Are you sure to delete this?')"><i
                                                class="fas fa-times"></i>
                                    </button>
                                    {!! Form::close() !!}
                                 @endif 
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

   
@endsection