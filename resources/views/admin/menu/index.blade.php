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
                            <th>Menu Name</th>
                            <th>Menu Link</th>
                            <th>Parent Menu</th>
                            <th>Order No</th>
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
                                <td>{{ $value->menu_name}}</td>
                                <td>{{ $value->slug }}</td>
                                <td>{{ $value->getParentMenu?$value->getParentMenu->menu_name:'' }}</td>
                                <td>{{ $value->orderno }}</td>
                               
                                <td class="{{ $value->is_active?'list-group-item-success':'list-group-item-danger'}}">{{ $value->is_active?'Enable':'Disable' }}</td>
                               
                                <td class="text-center">

                                {{-- @if(Auth()->user()->can('menu edit')) --}}
                                    <a href="{{url(config('siteconfig.adminRoute').'/menu/'.$value->id.'/edit')}}"
                                       class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                                       style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>

                                {{-- @endif  --}}

                                {{-- @if(Auth()->user()->can('menu delete'))   --}}  
                                    {!! Form::open(['route' => ["menu.destroy",$value->id], 'method'=>'delete',  'style'=>'display:inline']) !!}
                                    <button class="btn btn-danger btn-xs text-white" data-toggle="tooltip"
                                            title="Delete"
                                            style="display:inline;padding:2px 5px 3px 5px;"
                                            onclick="return confirm('Are you sure to delete this?')"><i
                                                class="fas fa-times"></i>
                                    </button>
                                    {!! Form::close() !!}
                                {{-- menu@endif --}}
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