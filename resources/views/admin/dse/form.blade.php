@extends('layouts.master')

@section('css')
<!-- Plugin css -->
<link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @if(isset($item))
        {!! Form::model($item, ['route' => ["stock.update", $item->id],'method' =>'PUT', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
        @else
        {!! Form::open(['route' => ["stock.store"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
        @endif
        <form class="custom-validation" action="#">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        {!! Form::label('acquisition_no', 'Acquisition No ') !!} <span class="la-required">*</span>
                        {!! Form::text('acquisition_no', null,['class'=>'form-control', 'placeholder'=>'Acquisition No','required'=>'required']) !!}
                        {!! $errors->first('acquisition_no', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <div style="margin-top: 30px;">
                            <button type="button" id="btn_search" class="btn btn-primary waves-effect waves-light mr-1">
                                Search
                            </button>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        {!! Form::label('store_id', 'Store Information') !!} <span class="la-required">*</span>
                        {!! Form::select('store_id', $storeItem,'', ['class' => 'form-control select2','id'=>'store_id']) !!}
                        {!! $errors->first('store_id', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>

            </div>




            <div id="item_list" class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="table" class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr class="success">
                                        <th>

                                            <input type="checkbox" onclick="$('input[name*=\'item\']').prop('checked', this.checked);">
                                        </th>
                                        <th>SL.</th>
                                        <th>Item Name</th>
                                        <th>Unit Name</th>
                                        <th>Item Serial</th>
                                        <th>Quantity</th>
                                        <th>Remarks</th>

                                    </tr>
                                </thead>


                                <tbody>
                                    @php
                                    $nr = 1
                                    @endphp
                                    @if(old('item_id'))

                                    @foreach(old('item_id') as $key => $value)
                                    <tr>
                                        <input type="hidden" name='quantity[{{ old("item_sytemid.$key") }}]' value='{{ old("quantity.$key")}}' />
                                        <input type="hidden" name='item_id[{{ old("item_sytemid.$key") }}]' value='{{ old("item_id.$key")}}' />
                                        <input type="hidden" name='itemname_text[{{ old("item_sytemid.$key") }}]' value='{{ old("itemname_text.$key")}}' />

                                        <input type="hidden" name='itemremarks[{{ old("item_sytemid.$key") }}]' value='{{ old("itemremarks.$key")}}' />
                                        <input type="hidden" name='unitname_text[{{ old("item_sytemid.$key") }}]' value='{{ old("unitname_text.$key")}}' />
                                        <input type="hidden" name='item_serial_no[{{ old("item_sytemid.$key") }}]' value='{{ old("item_serial_no.$key")}}' />
                                        <input type="hidden" name='item_sytemid[{{ old("item_sytemid.$key") }}]' value='{{ old("item_sytemid.$key")}}' />
                                        <input type="hidden" name='itemquantity[{{ old("itemquantity.$key") }}]' value='{{ old("item_sytemid.$key")}}' />


                                        <td> {!! Form::checkbox('item[]', old("item_sytemid.$key"),null,['class'=>'checkbox']) !!} </td>
                                        <td>{{ $nr++ }}</td>
                                        <td>{{ old("itemname_text.$key") }} </td>
                                        <td>{{ old("unitname_text.$key")}} </td>
                                        <td>{{ old("item_serial_no.$key")}} </td>
                                        <td>{{ old("itemquantity.$key")}} </td>
                                        <td>{{ old("itemremarks.$key")}} </td>

                                    </tr>


                                    @endforeach
                                    @endif
                                    @if(old('item_id'))
                                    <tr>
                                        <td colspan="6" class="text-right">
                                            <button type="submit" id="btn_search" class="btn btn-primary waves-effect waves-light mr-1">
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                    @endif

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </form>

    </div>
</div> <!-- end col -->




@endsection

@section('script')
<!-- Plugins js -->
<script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
<script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>

<script type="text/javascript">
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
    });

   

    $('#btn_search').click(function() {

        // var store_id = $("#store_id").find(':selected').val();
        var acquisition_no = $("#acquisition_no").val();

        if (acquisition_no) {

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('acquisition.getItemFilter')}}",
                data: {
                    acquisition_no: acquisition_no,
                    _token: '{{csrf_token()}}'
                },
                success: function(response) {
                    $('.item_list').show();
                    set_html(response);
                }
            });
        } else {
            $('.item_list').hide();
        }
    })

    function set_html(data) {
        var html = '';
        data.forEach((element, key) => {
            var serial = element.serial_no ? element.serial_no : '';
            var remarks = element.remarks?element.remarks:'';
            html += ' <tr>\
                                <td>\
                                    <input type="checkbox" name="item[' + element.id + ']" class="checkbox" value="' + element.id + '"/>\
                                    <input type="hidden" name="item_sytemid[' + element.id + ']" value="' + element.id + '"/>\
                                    <input type="hidden" name="quantity[' + element.id + ']" value="' + element.quantity + '"/>\
                                    <input type="hidden" name="item_id[' + element.id + ']" value="' + element.item_id + '"/>\
                                    <input type="hidden" name="itemremarks[' + element.id + ']" value="' + element.remarks + '" />\
                                    <input type="hidden" name="itemname_text[' + element.id + ']" value="' + element.item_name + '(' + element.item_code + ')" />\
                                    <input type="hidden" name="unitname_text[' + element.id + ']" value="' + element.item_measurment_units_name + '" />\
                                    <input type="hidden" name="item_serial_no[' + element.id + ']" value="' + serial + '" />\
                                    <input type="hidden" name="itemquantity[' + element.id + ']" value="' + element.quantity + '" />\
                                </td>\
                                <td>' + (key + 1) + '</td>\
                                <td>' + element.item_name + '(' + element.item_code + ')</td>\
                                <td>' + element.item_measurment_units_name + '</td>\
                                <td>' + serial + '</td>\
                                <td>' + element.quantity + '</td>\
                                <td>' + remarks + '</td>\
                            </tr>';
        });
        if (html == '') {
            html += ' <tr>\
                                <td colspan="6" class="text-center">\
                                    No Record Found\
                                </td>\
                            </tr>';
        }
        if (data.length) {
            html += ' <tr>\
                                <td colspan="6" class="text-right">\
                                <button type="submit" id="btn_search" class="btn btn-primary waves-effect waves-light mr-1">\
                                    Save\
                                </button>\
                                </td>\
                            </tr>';
        }
        $("#table").find('tbody').html(html);

    }

    $("button[type='submit']").click(function(){
       $(this).prop('disabled', true);
       $(this).parents('form').submit();
    })
</script>
@endsection