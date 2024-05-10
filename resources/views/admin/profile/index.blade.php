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
                            <th><i class="fa fa-random" aria-hidden="true"></i> Sorting</th>
                            <th>sdfasdf</th>
                            <th>sdfs</th>
                            <th>Parent</th>
                            <th>Is Show Menu</th>
                            <th>sdfsfs</th>
                            <th class="text-center" width="200px">sdfsfs</th>
                        </tr>
                        </thead>


                        <tbody id="tablecontents">

                      
                            <tr class="row1">
                                <td>One</td>
                                <td>One</td>
                                <td>One</td>
                                <td>One</td>
                                <td>One</td>
                                <td>One</td>
                                <td>One</td>

                            </tr>
                        

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
            $("#tablecontents").sortable({
                items: "tr",
                cursor: 'move',
                opacity: 0.8,
                update: function () {
                    sendOrderToServer();
                }
            }).disableSelection();

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