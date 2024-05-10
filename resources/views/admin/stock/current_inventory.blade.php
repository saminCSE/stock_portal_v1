@extends('layouts.master')

@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<!-- datatables css -->
<link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">


            <div class="box-header with-border text-center">
                <h3 class="box-title">Current Inventory</h3>
            </div>
            <div class="card-body">

                {!! Form::open(['route' => ["inventory.searchCurrentInventory"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}

                <div class="row ">
                    <div class="col-lg-3">
                        <div class="form-group">
                            {!! Form::label('item_typeid', ' Item Type') !!}
                            {!! Form::select('item_typeid', $item_type, null, ['class' => 'form-control select2','id'=>'item_type_id']) !!}
                            {!! $errors->first('item_typeid', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            {!! Form::label('item_category', ' Item Category') !!}
                            {!! Form::select('item_category', [], null, ['class' => 'form-control select2','id'=>'item_category_id' ]) !!}
                            {!! $errors->first('item_category', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            {!! Form::label('store_id', ' Store') !!}
                            {!! Form::select('store_id', $store, null, ['class' => 'form-control select2']) !!}
                            {!! $errors->first('store_id', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <div style="margin-top: 30px;">
                                <button type="button" id="btn_search" class="btn btn-primary waves-effect waves-light mr-1">
                                    Search
                                </button>

                            </div>
                        </div>
                    </div>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="row" id="listofcontent" style="display:none">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="table" class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr class="success">
                            <th> SL.</th>
                            <th>Item Type</th>
                            <th>Item Category</th>
                            <th>Store</th>
                            <th>Item Name</th>
                            <th>Current Stock</th>
                            <th>Item Unit</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->


<!-- Modal Start -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Item List</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">

                <h5>Item Name : <span id="itemname"></span> </h5>
                <div id="itemcontent">
                
                <img src="{{asset('assets/images/loading.gif')}}" alt="Loading...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@section('script')

<!-- Plugins js -->
<script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
<script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js')}}"></script>

<script>
    $('#btn_search').click(function() {
        var item_typeid = $("select[name='item_typeid']").val();
        var item_category = $("select[name='item_category']").val();
        var store_id = $("select[name='store_id']").val();

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('inventory.searchCurrentInventory')}}",
            data: {
                item_typeid: item_typeid,
                item_category: item_category,
                store_id: store_id,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
                $("#listofcontent").show();
                set_html(response);
            }
        });
    })



    function set_html(data) {
        var html = '';
        data.forEach((element, key) => {
            var serial = element.serial_no ? element.serial_no : '';
            let item_button = '';
            if (element.is_serial_no === 1) {
                item_button = '<button type="button" id="btn_showitem_'+key+'" store_id="'+element.store_id+'" stock_id="'+element.id+'" class="btn btn-success waves-effect waves-light mr-1 btn_showitem">\
                                    Show Item\
                                </button>';
            }
            html += ' <tr>\
                                <td>' + (key + 1) + '</td>\
                                <td>' + element.type_name + '</td>\
                                <td>' + element.category_name + '</td>\
                                <td>' + element.store_name + '</td>\
                                <td>' + element.item_name + '</td>\
                                <td>' + element.stock_quantity + '</td>\
                                <td>' + element.item_measurment_units_name + '</td>\
                                <td>\
                                <a href={{url(config("siteconfig.adminRoute"))}}/stockadjust/create?adjustment='+element.id+'> <button type="button" id="btn_adjust_stock" class="btn btn-info waves-effect waves-light mr-1">\
                                    Adjust Stock\
                                </button></a>\
                                ' + item_button + ' \
                                 </td>\
                            </tr>';
        });
        if (html == '') {
            html += ' <tr>\
                                <td colspan="8" class="text-center">\
                                    No Record Found\
                                </td>\
                            </tr>';
        }

        $("#table").find('tbody').html(html);

    }



    $('body').on('change', '#item_type_id', function() {
        var item_type_id = $("#item_type_id").find(':selected').val();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('itemcategory.typecategory')}}",
            data: {
                item_type: item_type_id,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {

                $("#item_category_id").select2('destroy').empty().select2(

                    {
                        data: response.results
                    });
            }
        });
    })


    $(document).on('click', '.btn_showitem', function() {
        var store_id = $(this).attr('store_id');
        var stock_id = $(this).attr('stock_id');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('inventory.getStockSerialItemNo')}}",
            data: {
                store_id: store_id,
                stock_id: stock_id,
                _token: '{{csrf_token()}}'
            },
            beforeSend:function(){
                $('#myModal').modal();
            },
            success: function(response) {
              
               set_html_forshowitem(response)
            }
        });

       
    })

    function set_html_forshowitem(data) {
        var html = '';
        data.forEach((element, key) => {
            html += ' <tr>\
                                <td>' + (key + 1) + '</td>\
                                <td>' + element.serial_no + '</td>\
                            </tr>';
        });
        if (html == '') {
            html += ' <tr>\
                                <td colspan="2" class="text-center">\
                                    No Record Found\
                                </td>\
                            </tr>';
        }


        let tablhtml = '<table id="table" class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">\
                    <thead>\
                        <tr class="success">\
                            <th> SL.</th>\
                            <th>Serial No.</th>\
                        </tr>\
                    </thead>\
                    <tbody>\
                    '+html+'\
                    </tbody>\
                </table>';
        $('#myModal').find(".modal-body").find('#itemcontent').html(tablhtml);
        if(data.length) {
            $('#myModal').find(".modal-body").find('#itemname').html(data[0]['item_name']);
        }
        else {
            $('#myModal').find(".modal-body").find('#itemname').html('');
        }
       
        

    }
</script>

@endsection