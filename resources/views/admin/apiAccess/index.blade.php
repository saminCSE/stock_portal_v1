@extends('layouts.master')
@section('css')
    <!-- datatables css -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
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
                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="th-sm">ID</th>
                                    <th class="th-sm">Name</th>
                                    <th class="th-sm">Username</th>
                                    <th class="th-sm">Password</th>
                                    <th class="th-sm">Status</th>
                                    <th class="th-sm">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $list)
                                    <tr>
                                        <td>{{ $list->id }}</td>
                                        <td>{{ $list->name }}</td>
                                        <td>{{ $list->username }}</td>
                                        <td>{{ $list->password }}</td>
                                        {{-- <td>
                                            @if ($list->status == 1)
                                                <a class="text-success">Active</a>
                                            @elseif($list->status == 0)
                                                <a class="text-danger">Deactive</a>
                                            @endif
                                        </td> --}}
                                        <td>
                                            <input type="checkbox" class="toggle-status" data-id="{{ $list->id }}"
                                                data-toggle="toggle" data-on="Active" data-off="Deactive"
                                                {{ $list->status == 1 ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            {{-- <a href="{{ url(config('siteconfig.adminRoute') . '/apiaccess/' . $list->id . '/edit') }}"
                                                class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit"
                                                style="display:inline;padding:2px 5px 3px 5px;"><i
                                                    class="fa fa-edit"></i></a> --}}

                                            {!! Form::open([
                                                'route' => ['apiaccess.destroy', $list->id],
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
<script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    $(document).ready(function () {
        $('.toggle-status').change(function () {
            var id = $(this).data('id');
            var status = $(this).prop('checked') ? 1 : 0;
            // Perform an AJAX request to update the status
            $.ajax({
                url: "{{ url(config('siteconfig.adminRoute')) }}/update-status/" + id,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function (response) {
                    if (response.success) {
                        // Optional: Display success message or update UI
                        console.log('Status updated successfully');
                    } else {
                        // Optional: Handle errors
                        console.log('Error updating status');
                    }
                },
                error: function () {
                    // Optional: Handle errors
                    console.log('Error updating status');
                }
            });
        });
    });
</script>
@endsection
