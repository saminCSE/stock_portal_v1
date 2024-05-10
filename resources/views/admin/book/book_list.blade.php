@extends('layouts.master')
@section('css')
<!-- datatables css -->
<link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

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
                                <th class="th-sm">SL.</th>
                                <th class="th-sm">Title</th>
                                <th class="th-sm">Short Description</th>
                                <th class="th-sm">File</th>
                                <th class="th-sm">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($books as $book)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$book->title}}</td>
                                <td>{{ Str::limit($book->description, 50) }}</td>
                                <td>
                                    <div>
                                        @if(isset($book->file))
                                        {{-- <img src="{{ asset('uploads/books/'.$book->file) }}" width="80px"> --}}
                                        <a target="__blank" href="{{ asset($book->file) }}">Preview</a>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <a href="{{url(config('siteconfig.adminRoute').'/book/edit_book/'.$book->id)}}" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit" style="display:inline;padding:2px 5px 3px 5px;" ><i class="fa fa-edit"></i></a>
                                    <a href="{{url(config('siteconfig.adminRoute').'/book/delete_book/'.$book->id)}}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete?');" data-toggle="tooltip" title="Delete" style="display:inline;padding:2px 5px 3px 5px;" ><i class="fa fa-trash"></i></a>
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
<script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
<script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
  $(function() {
    $('.toggle-class').change(function clickAlert() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var id = $(this).data('id');
        return confirm("Are you sure you want to update status?");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url(config('siteconfig.adminRoute').'/changeStatus')}}",
            data: {'is_published': status, 'id': id},
            success: function(data){
              console.log(data.success)
            }
        });
    })
  })
  function clicked() {
    alert('clicked');
}
</script>
@endsection
