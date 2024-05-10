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
                            <tr>
                            <th>Item Name</th>
                            <th>Current Stock</th>
                            <th>Notify Number</th>
                            </tr>
                        </thead>


                        <tbody id="tablecontents">
                        @foreach($stock as $key=>$val)
                            <tr>
                            <td>{{$val->item_name}}</td>
                            <td>{{$val->stock_quantity}}</td>
                            <td>{{$val->notify_number}}</td>
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
         

          
        });
    </script>

@endsection