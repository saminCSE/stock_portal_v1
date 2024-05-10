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
                            <th>Full Name</th>
                            <th>User Name</th>
                            <th>Email Address</th>
                            <th>Role Name</th>
                            <th>Office Name</th>
                            <th>Store Name</th>
                            <th>Status</th>
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
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->username  }}</td>
                                <td>{{ $value->email  }}</td>
                                <td>{{ $value->role?$value->role->name:''  }}</td>
                                <td>{{ $value->office?$value->office->name:''  }}</td>
                                <td>{{ $value->store?$value->store->name:''  }}</td>
                               
                               
                                <td class="{{ $value->active_status?'list-group-item-success':'list-group-item-danger'}}">{{ $value->active_status?'Enable':'Disable' }}</td>
                               
                                <td class="text-center">
                                     @if(Auth()->user()->can('user edit'))
                                    <a href="{{url(config('siteconfig.adminRoute').'/user/'.$value->id.'/edit')}}"
                                       class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                                       style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>

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

    <script>
        $(function () {
         

            function sendOrderToServer() {
                var order = [];
                $('tr.row1').each(function (index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1
                    });
                });

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "",
                    data: {
                        order: order,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        if (response == "Update Successfully.") {
                            location.reload();
                        } else {
                            console.log(response);
                        }
                    }
                });

            }
        });
    </script>

@endsection