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
                            <th>Store Name</th>
                            <th>Item Name</th>
                            <th>Stock Quantity</th>
                           
                        </tr>
                        </thead>


                        <tbody id="tablecontents">

                      
                        @foreach($collections as $key=>$value)
                            @php
                                $id = $value->id;
                                $notifyclass = '';

                                if($value->item) {
                                    if($value->item->notify_number > $value->stock_quantity) {
                                        $notifyclass = 'alert alert-danger';
                                    }
                                }

                            @endphp

                            <tr class="row1 {{ $notifyclass }}" data-id="{{ $id }}">
                               
                                <td> {{ $key+1 }} </td>
                                <td>{{ $value->store?$value->store->name:'' }}</td>
                                <td>{{ $value->item?$value->item->item_name:'' }} ({{ $value->item?$value->item->item_code:'' }})</td>
                                <td> {{ $value->stock_quantity }} </td>
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