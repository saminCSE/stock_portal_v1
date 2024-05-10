@extends('layouts.master')

@section('css')
    <!-- datatables css -->
    <!-- <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/> -->
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css" />

    <style>
        table,
        td,
        th {
            vertical-align: middle !important;
        }

        table th {
            font-weight: bold;
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>
@endsection
@section('content')
    <div class="card shadow mb-12">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="box-header with-border text-center">
                        <h3 class="box-title">Company Basic Information</h3>
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap table-responsive"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="th-sm">SL.</th>
                                    <th class="th-sm">Company name</th>
                                    <th class="th-sm">Company Code</th>
                                    {{-- <th class="th-sm">Company Description</th>
                                    <th class="th-sm">Incorporation Date</th>
                                    <th class="th-sm">Scrip Code(DSE)</th>
                                    <th class="th-sm">Scrip Code(CSE)</th> --}}
                                    <th class="th-sm">Listing Year(DSE)</th>
                                    {{-- <th class="th-sm">Listing Year(CSE)</th> --}}
                                    <th class="th-sm">Market Category</th>
                                    {{-- <th class="th-sm">Electronic Share</th>
                                    <th class="th-sm">Corporate office address</th> --}}
                                    <th class="th-sm">Head office address</th>
                                    {{-- <th class="th-sm">Fax</th> --}}
                                    <th class="th-sm">Phone</th>
                                    {{-- <th class="th-sm">Authorized Capital</th>
                                    <th class="th-sm">Paidup Capital</th>
                                    <th class="th-sm">Face par Value</th>
                                    <th class="th-sm">Outstanding Securities no</th>
                                    <th class="th-sm">Debut Trading Date</th> --}}
                                    <th class="th-sm">Type of Instrument</th>
                                    {{-- <th class="th-sm">Market Lot</th>
                                    <th class="th-sm">Market Price</th> --}}
                                    {{-- <th class="th-sm">Sector Id</th> --}}
                                    <th class="th-sm"> Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $sr = ($info->currentpage() - 1) * $info->perpage();
                                @endphp
                                @foreach ($info as $list)
                                    <tr>
                                        <td> {{ $loop->iteration }} </td>
                                        <td>{{ $list->company_name }}</td>
                                        <td>{{ $list->code }}</td>
                                        {{-- <td>{{ $list->company_description }}</td>
                                        <td>{{ $list->incorporation_date }}</td>
                                        <td>{{ $list->scrip_code_dse }}</td>
                                        <td>{{ $list->scrip_code_cse }}</td> --}}
                                        <td>{{ $list->listing_year_dse }}</td>
                                        {{-- <td>{{ $list->listing_year_cse }}</td> --}}
                                        <td>{{ $list->market_category }}</td>
                                        {{-- <td>
                                            @if ($list->electronic_share == 1)
                                                <a class="btn btn-sm ">Yes</a>
                                            @elseif($list->electronic_share == 0)
                                                <a class="btn btn-sm ">No</a>
                                            @endif
                                        </td>
                                        <td>{{ $list->corporate_office_address }}</td> --}}
                                        <td>{{ $list->head_office_address }}</td>
                                        {{-- <td>{{ $list->fax }}</td> --}}
                                        <td>{{ $list->phone }}</td>
                                        {{-- <td>{{ $list->authorized_capital }}</td>
                                        <td>{{ $list->paidup_capital }}</td>
                                        <td>{{ $list->face_par_value }}</td>
                                        <td>{{ $list->outstanding_securities_no }}</td>
                                        <td>{{ $list->debut_trading_date }}</td> --}}
                                        <td>{{ $list->type_of_instrument }}</td>
                                        {{-- <td>{{ $list->market_lot }}</td>
                                        <td>{{ $list->market_price }}</td> --}}
                                        {{-- <td>{{ $list->sector_id }}</td> --}}
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm btn-rounded viewbtn"
                                                value="{{ $list->id }}" data-toggle="modal"
                                                data-target="#CompanybasicinfoModal">
                                                <i class="fas fa-eye"></i></button>
                                            <br />
                                            <br />
                                            <a href="{{ route('edit_company_basic_info', ['id' => $list->id]) }}"
                                                class="btn btn-primary btn-sm btn-rounded editbtn">
                                                <i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if (!count($info))
                                    <tr class="row1">
                                        <td colspan="8" class="text-center"> No record found. </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="pagination_link">
                            {{ $info->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade bd-example-modal-lg" id="CompanybasicinfoModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <div class="text-center">
                        <h2>Company Basic Information</h2>
                    </div>
                    <br />
                    <thead>
                        <tr>
                            <th class="th-sm">Company name</th>
                            <td id="company_name"></td>
                        </tr>
                        <tr>
                            <th class="th-sm">Company Xcode</th>
                            <td id="xcode"></td>
                        </tr>
                        <tr>
                            <th class="th-sm">Company Description</th>
                            <td id="company_description"></td>
                        </tr>
                        <tr>
                            <th class="th-sm">Incorporation Date</th>
                            <td id="incorporation_date"></td>
                        </tr>
                        <tr>
                            <th class="th-sm">Scrip Code(DSE)</th>
                            <td id="scrip_code_dse"></td>
                        </tr>
                        <tr>
                            <th class="th-sm">Scrip Code(CSE)</th>
                            <td id="scrip_code_cse"></td>
                        </tr>
                        <tr>
                            <th class="th-sm">Listing Year(DSE)</th>
                            <td id="listing_year_dse"></td>
                        </tr>
                        <tr>
                            <th class="th-sm">Listing Year(CSE)</th>
                            <td id="listing_year_cse"></td>
                        </tr>
                        <tr>
                            <th class="th-sm">Market Category</th>
                            <td id="market_category"></td>
                        </tr>
                        <tr>
                            <th class="th-sm">Electronic Share</th>
                            <td id="electronic_share"></td>
                        </tr>
                        <tr>
                            <th class="th-sm">corporate office address</th>
                            <td id="corporate_office_address"></td>
                        </tr>
                        <tr>
                            <th class="th-sm">Factory office address</th>
                            <td id="factory_office_address"></td>
                        </tr>
                        <tr>
                            <th class="th-sm">Head office address</th>
                            <td id="head_office_address"></td>
                        </tr>
                        <tr>
                            <th class="th-sm">fax</th>
                            <td id="fax"></td>
                        </tr>
                        <tr>
                            <th class="th-sm">Phone</th>
                            <td id="phone"></td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div> --}}
    <div class="modal fade bd-example-modal-lg" id="CompanybasicinfoModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title text-center">Company Basic Information</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered dt-responsive nowrap table-responsive">
                        <tbody>
                            <tr>
                                <th class="th-sm">Company name</th>
                                <td id="company_name"></td>
                                <th class="th-sm">Company Code</th>
                                <td id="company_code"></td>
                            </tr>
                            <tr>
                                <th class="th-sm">Company Description</th>
                                <td id="company_description"></td>
                                <th class="th-sm">Incorporation Date</th>
                                <td id="incorporation_date"></td>
                            </tr>
                            <!-- Add more rows as needed -->
                            <tr>
                                <th class="th-sm">Scrip Code(DSE)</th>
                                <td id="scrip_code_dse"></td>
                                <th class="th-sm">Scrip Code(CSE)</th>
                                <td id="scrip_code_cse"></td>
                            </tr>
                            <tr>
                                <th class="th-sm">Listing Year(DSE)</th>
                                <td id="listing_year_dse"></td>
                                <th class="th-sm">Listing Year(CSE)</th>
                                <td id="listing_year_cse"></td>
                            </tr>
                            <tr>
                                <th class="th-sm">Market Category</th>
                                <td id="market_category"></td>
                                <th class="th-sm">Electronic Share</th>
                                <td id="electronic_share"></td>
                            </tr>
                            <tr>
                                <th class="th-sm">Corporate office address</th>
                                <td id="corporate_office_address"></td>
                                <th class="th-sm">Head office address</th>
                                <td id="head_office_address"></td>
                            </tr>
                            <tr>
                                <th class="th-sm">Fax</th>
                                <td id="fax"></td>
                                <th class="th-sm">Phone</th>
                                <td id="phone"></td>
                            </tr>
                            <tr>
                                <th class="th-sm">Authorized Capital</th>
                                <td id="authorized_capital"></td>
                                <th class="th-sm">Paidup Capital</th>
                                <td id="paidup_capital"></td>
                            </tr>
                            <tr>
                                <th class="th-sm">Face par Value</th>
                                <td id="face_par_value"></td>
                                <th class="th-sm">Outstanding Securities no</th>
                                <td id="outstanding_securities_no"></td>
                            </tr>
                            <tr>
                                <th class="th-sm">Debut Trading Date</th>
                                <td id="debut_trading_date"></td>
                                <th class="th-sm">Type of Instrument</th>
                                <td id="type_of_instrument"></td>
                            </tr>
                            <tr>
                                <th class="th-sm">Market Lot</th>
                                <td id="market_lot"></td>
                                <th class="th-sm">Market Price</th>
                                <td id="market_price"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- Plugins js -->
    <!-- <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
                                                                                                                                                                                                                                    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
                                                                                                                                                                                                                                    <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script> -->
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(document).on('click', '.viewbtn', function(e) {
            e.preventDefault();
            var id = $(this).val();
            console.log(id);
            $('#CompanybasicinfoModal').modal('show');
            $.ajax({
                type: "get",
                url: "{{ url(config('siteconfig.adminRoute') . '/company_basic_info/details') }}/" + id,
                success: function(response) {
                    if (response.status == 404) {
                        $("#success_message").html("");
                        $("#success_message").addClass('alert alert-danger');
                        $("#success_message").text(response.message);
                    } else {
                        var status = "No";
                        if (response.info.electronic_share == 1) {
                            status = "Yes";
                        }
                        $('#company_name').html(response.info.company_name);
                        $('#company_code').html(response.info.code);
                        $('#company_description').html(response.info.company_description);
                        $('#incorporation_date').html(response.info.incorporation_date);
                        $('#scrip_code_dse').html(response.info.scrip_code_dse);
                        $('#scrip_code_cse').html(response.info.scrip_code_cse);
                        $('#listing_year_dse').html(response.info.listing_year_dse);
                        $('#listing_year_cse').html(response.info.listing_year_cse);
                        $('#market_category').html(response.info.market_category);
                        $('#electronic_share').html(status);
                        $('#corporate_office_address').html(response.info.corporate_office_address);
                        $('#head_office_address').html(response.info.head_office_address);
                        $('#fax').html(response.info.fax);
                        $('#phone').html(response.info.phone);
                        $('#authorized_capital').html(response.info.authorized_capital);
                        $('#paidup_capital').html(response.info.paidup_capital);
                        $('#face_par_value').html(response.info.face_par_value);
                        $('#outstanding_securities_no').html(response.info.outstanding_securities_no);
                        $('#debut_trading_date').html(response.info.debut_trading_date);
                        $('#type_of_instrument').html(response.info.type_of_instrument);
                        $('#market_lot').html(response.info.market_lot);
                        $('#market_price').html(response.info.market_price);
                    }
                }
            });
        });
        $(function() {
            $('.datepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd',
            });
        });
    </script>
@endsection
