@extends('layouts.master')

@section('content')
    <div class="card shadow mb-12">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status')}}</div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th class="th-sm">SL</th>
                                <th class="th-sm">Instrument Name</th>
                                <th class="th-sm">Quantity(Volume)</th>
                                <th class="th-sm">Value(Turnover)(MN)</th>
                                <th class="th-sm">Trades</th>
                                <th class="th-sm">Max Price</th>
                                <th class="th-sm">Min Price</th>
                                <th class="th-sm">Date</th>
                                <th class="th-sm">Action</th>

                            </tr>
                            </thead>

                            <tbody>
                            @foreach($blockTransactions as $blockTransaction)
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$blockTransaction->instrument_code}}</td>
                                    <td>{{$blockTransaction->quantity}}</td>
                                    <td>{{$blockTransaction->value}}</td>
                                    <td>{{$blockTransaction->trades}}</td>
                                    <td>{{$blockTransaction->max_price}}</td>
                                    <td>{{$blockTransaction->min_price}}</td>
                                    <td>{{$blockTransaction->transaction_date}}</td>
                                    <td>
                                        <a href="{{url(config('siteconfig.adminRoute').'/blocktransaction/'.$blockTransaction->id.'/edit')}}" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>

                                        {!! Form::open(['route' => ["blocktransaction.destroy",$blockTransaction->id], 'method'=>'delete', 'style'=>'display:inline']) !!}
                                        <button class="btn btn-danger btn-xs text-white" data-toggle="tooltip" title="Delete" style="display:inline;padding:2px 5px 3px 5px;" onclick="return confirm('Are you sure to delete this?')"><i class="fas fa-times"></i>
                                        </button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
{{--                                @if(!count($announce))--}}
{{--                                    <tr class="row1">--}}
{{--                                        <td colspan="8" class="text-center"> No record found. </td>--}}

{{--                                    </tr>--}}

{{--                                @endif--}}
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




