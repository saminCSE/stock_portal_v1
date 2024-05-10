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
                                <th class="th-sm">Category Name</th>
                                <th class="th-sm">Title</th>
                                <th class="th-sm">Published Date</th>
                                <th class="th-sm">Short Description</th>
                                <th class="th-sm">Source</th>
                                <th class="th-sm">File</th>
                                <th class="th-sm">Status</th>
                                <th class="th-sm">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($news as $list)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$list->name}}</td>
                                <td>{{$list->title}}</td>
                                <td>{{$list->published_date}}</td>
                                <td>{{ Str::limit($list->short_description, 50) }}</td>
                                <td>{{$list->source}}</td>
                                <td>
                                    <div>
                                        @if(isset($list))
                                        <img src="{{ asset('uploads/news/thumbs/'.$list->file) }}" width="80px">
                                        @endif 
                                    </div>
                                </td>
                                <td> <input data-id="{{$list->id}}" class="toggle-class" type="checkbox" data-onstyle="success" onclick="clickAlert()" data-offstyle="danger" data-toggle="toggle"   data-on="Published" data-off="Draft" {{ $list->is_published ? 'checked' : '' }} ></td>
                                <!-- <td> @if($list->is_published==1)
                                    <a class="btn btn-sm btn-success text-white" data-id="{{$list->id}}">Published</a>
                                    @elseif($list->is_published==0)
                                    <a class="btn btn-sm btn-danger text-white" >Draft</a>
                                    @endif
                                </td> -->
                                <td>
                                    <a href="{{url(config('siteconfig.adminRoute').'/newsportal/'.$list->id.'/edit')}}" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Edit" style="display:inline;padding:2px 5px 3px 5px;" ><i class="fa fa-edit"></i></a>

                                    {!! Form::open(['route' => ["newsportal.destroy",$list->id], 'method'=>'delete', 'style'=>'display:inline']) !!}
                                    <button class="btn btn-danger btn-xs text-white" data-toggle="tooltip" title="Delete" style="display:inline;padding:2px 5px 3px 5px;" onclick="return confirm('Are you sure to delete this?')"><i class="fas fa-times"></i>
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