@extends('layouts.master')
@section('css')
<!-- datatables css -->
<link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @if (session('status'))
    <div class="alert alert-success">{{ session('status')}}</div>
    @endif
    <div class="card">
        <div class="card-body">
        @if(isset($item))
            {!! Form::model($item, ['route'=>["newscategory.update_category", $item->id],'method' =>'PUT', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
            @else
            {!! Form::open(['route' => ["newscategory.create_newscategory"],'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
            @endif
            <form class="custom-validation" action="" method="">
                <div class="row">
                <div class="col-md-3 text-right">
                {!! Form::label('name', 'Category Name') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('name', null,['class'=>'form-control']) !!}
                            {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-3 text-right">
                {!! Form::label('is_active', 'Status') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::select('is_active',$isstatus,isset($item->is_active) ? $item->is_active : 1,['class' => 'form-control']) !!}
                            {!! $errors->first('is_active', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 text-right">
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div> <!-- end col -->
    <br>

    <div class="card shadow mb-12">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th class="th-sm">SL</th>
                        <th class="th-sm">Category Name</th>
                        <th class="th-sm">Status</th>
                        <!-- <th class="th-sm">Batch Id</th>
                        <th class="th-sm">Market Id</th> -->
                        <th class="th-sm">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($category as $list)
                    <tr>
                       <td>{{$loop->iteration}}</td>
                        <td>{{$list->name}}</td>
                        <td>   @if($list->is_active==1)
                        <a  class="btn btn-sm btn-success text-white ">Active</a>
                        @elseif($list->is_active==0)
                        <a  class="btn btn-sm btn-danger text-white">Deactive</a>
                        @endif</td>
                        <!-- <td>{{$list->batch_id}}</td>
                        <td>{{$list->market_id}}</td> -->
                        <td>
                            <a href="{{route('newscategory.edit_category',['id'=>$list->id])}}" class="btn btn-primary btn-sm btn-rounded editbtn">
                                <i class="fas fa-edit"></i></a>
                            <a href="{{route('newscategory.category_delete', ['id'=>$list->id])}}" class="btn btn-danger btn-sm btn-rounded" onclick="return confirm('Are you sure to delete this category?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
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
@endsection
