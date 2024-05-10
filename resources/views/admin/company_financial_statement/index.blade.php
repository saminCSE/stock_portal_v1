@extends('layouts.master')

@section('content')
    <div class="card shadow mb-12">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="th-sm">SL</th>
                                    <th class="th-sm">Instrument Name</th>
                                    <th class="th-sm">Date</th>
                                    <th class="th-sm">Quater</th>
                                    <th class="th-sm">File</th>
                                    <th class="th-sm">Status</th>
                                    <th class="th-sm">Action</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($company_financial_statements as $company_financial_statement)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $company_financial_statement->instrument_name }}</td>
                                        <td>{{ $company_financial_statement->date_time }}</td>
                                        <td>{{ $company_financial_statement->quatar_text }}</td>
                                        <td><a class="btn btn-success btn-sm"
                                                href="{{ asset($company_financial_statement->file) }}">Download PDF</a></td>

                                        <td>
                                            <p
                                                class="btn btn-sm m-0 {{ $company_financial_statement->is_active == 1 ? 'btn-success' : 'btn-danger' }}">
                                                {{ $company_financial_statement->is_active == 1 ? 'Active' : 'Inactive' }}
                                            </p>
                                        </td>

                                        <td>
                                            <a href="{{ url(config('siteconfig.adminRoute') . '/company_financial_statement/' . $company_financial_statement->id . '/edit') }}"
                                                class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                                                style="display:inline;padding:2px 5px 3px 5px;"><i
                                                    class="fa fa-edit"></i></a>

                                            {!! Form::open([
                                                'route' => ['company_financial_statement.destroy', $company_financial_statement->id],
                                                'method' => 'delete',
                                                'style' => 'display:inline',
                                            ]) !!}
                                            <button class="btn btn-danger btn-xs text-white" data-toggle="tooltip"
                                                title="Delete" style="display:inline;padding:2px 5px 3px 5px;"
                                                onclick="return confirm('Are you sure to delete this?')"><i
                                                    class="fas fa-times"></i>
                                            </button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                    {{--                                @if (!count($announce)) --}}
                                    {{--                                    <tr class="row1"> --}}
                                    {{--                                        <td colspan="8" class="text-center"> No record found. </td> --}}

                                    {{--                                    </tr> --}}

                                    {{--                                @endif --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
