@extends('layouts.master')
@section('css')
    <!-- datatables css -->
    {{-- <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" /> --}}
@endsection

@section('content')
    <div class="card shadow mb-12">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <form action="{{ route('instrument.list') }}" class="d-flex justify-content-end mb-3"
                                method="GET">
                                <div style="width:300px; margin-right:20px;">
                                    <select class="form-control select2" name="sector">
                                        <option value='-1'>Select Sector</option>
                                        @foreach ($sector_list as $sectorr)
                                            <option value="{{ $sectorr->id }}"
                                                {{ $request->input('sector') == $sectorr->id ? 'selected' : '' }}>
                                                {{ $sectorr->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="width:300px; margin-right:20px;">
                                    <select class="form-control select2" name="instrument_id">
                                        <option value='-1'>Select Instrument</option>
                                        @foreach ($instrument_list as $instrumentt)
                                            <option value="{{ $instrumentt->id }}"
                                                {{ $request->input('instrument_id') == $instrumentt->id ? 'selected' : '' }}>
                                                {{ $instrumentt->instrument_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="width:300px; margin-right:20px;">
                                    <select class="form-control select2 select2-multiple" multiple="multiple"
                                        name="index[]">
                                        {{-- <option value='-1'>Select Index</option> --}}
                                        <option value="DSEX"
                                            {{ in_array('DSEX', $request->input('index', [])) ? 'selected' : '' }}>DSEX
                                        </option>
                                        <option value="DSES"
                                            {{ in_array('DSES', $request->input('index', [])) ? 'selected' : '' }}>DSES
                                        </option>
                                        <option value="DS30"
                                            {{ in_array('DS30', $request->input('index', [])) ? 'selected' : '' }}>DSE30
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mb-3">Search</button>
                            </form>
                        </div>

                        <table id="" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="th-sm">ID</th>
                                    <th class="th-sm">Exchange Name</th>
                                    <th class="th-sm">Sector Name</th>
                                    <th class="th-sm">Instrument Name</th>
                                    <th class="th-sm">Instrument Code</th>
                                    <th class="th-sm">IsIn</th>
                                    <th class="th-sm">Is spot</th>
                                    <th class="th-sm">Status</th>
                                    <!-- <th class="th-sm">Batch Id</th>
                                    <th class="th-sm">Market Id</th> -->
                                    <th class="th-sm">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($instrument as $list)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($list->exchange_id == 1)
                                                <a class="btn btn-sm ">DSEX</a>
                                            @elseif($list->exchange_id == 2)
                                                <a class="btn btn-sm ">CSEX</a>
                                            @endif
                                        </td>
                                        <td>{{ $list->sector_name }}</td>
                                        <td>{{ $list->name }}</td>
                                        <td>{{ $list->instrument_code }}</td>
                                        <td>{{ $list->isin }}</td>
                                        <td>
                                            @if ($list->is_spot == 1)
                                                Yes
                                            @elseif($list->is_spot == 0)
                                                No
                                            @endif
                                        </td>
                                        <td>
                                            @if ($list->active == 1)
                                                <a class="btn btn-sm btn-success text-white ">Active</a>
                                            @elseif($list->active == 0)
                                                <a class="btn btn-sm btn-danger text-white">Deactive</a>
                                            @endif
                                        </td>
                                        <!-- <td>{{ $list->batch_id }}</td>
                                    <td>{{ $list->market_id }}</td> -->
                                        <td>
                                            <a href="{{ route('instrument.edit_instrument', ['id' => $list->id]) }}"
                                                class="btn btn-primary btn-sm btn-rounded editbtn">
                                                <i class="fas fa-edit"></i></a>
                                            <a href="{{ route('instrument.instrument_delete', ['id' => $list->id]) }}"
                                                class="btn btn-danger btn-sm btn-rounded"
                                                onclick="return confirm('Are You sure to Delete this');">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $instrument->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {{-- <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script> --}}
    <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
@endsection
