@extends('layouts.master')

@section('css')
    <!-- Plugin css -->
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet"
          type="text/css"/>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            @if(isset($item))
                {!! Form::model($item, ['route' => ["user.update", $item->id],'method' =>'PUT', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
            @else
                {!! Form::open(['route' => ["user.store"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
            @endif
            <form class="custom-validation" action="#">
            <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('name', 'Full Name') !!} <span class="la-required">*</span>
                            {!! Form::text('name', null,['class'=>'form-control', 'placeholder'=>'Full Name']) !!}
                            {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                   
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('username', 'User Name') !!} <span class="la-required">*</span>
                            {!! Form::text('username', null,['class'=>'form-control', 'placeholder'=>'User Name']) !!}
                            {!! $errors->first('username', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                   
                    
                </div>
                <div class="row">
                    <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('email', 'Email') !!} <span class="la-required">*</span>
                                {!! Form::text('email', null,['class'=>'form-control', 'placeholder'=>'Email','required'=>'required']) !!}
                                {!! $errors->first('email', '<p class="help-block text-danger">:message</p>') !!}
                            </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('active_status', 'Status') !!} 
                            {!! Form::select('active_status', $isActivestatus, isset($item->active_status) ? $item->active_status : 1, ['class' => 'form-control']) !!}
                            {!! $errors->first('active_status', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                  
                </div>
                <div class="row">
                <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('password', 'Password') !!} @if(!isset($item))<span class="la-required">*</span> @endif
                            <input type="password" class="form-control" name="password" placeholder="Password" value="" autocomplete="off"/>
                            {!! $errors->first('password', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('password_confirmation', 'Confirm Password') !!} 
                            @if(!isset($item))<span class="la-required">*</span> @endif
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Password confirmation" value="" autocomplete="off"/>
                            {!! $errors->first('password_confirmation', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>

                   

                </div>

                <div class="row">
                
                    <div class="col-lg-6">
                       <div class="form-group">
                           {!! Form::label('role_id', 'Role Name') !!} 
                           {!! Form::select('role_id', $role, isset($item->role_id) ? $item->role_id : '', ['class' => 'form-control']) !!}
                           {!! $errors->first('role_id', '<p class="help-block text-danger">:message</p>') !!}
                       </div>
                    </div>
                    <div class="col-lg-6">
                       <div class="form-group">
                           {!! Form::label('office_id', 'Office Name') !!} 
                           {!! Form::select('office_id', $office, isset($item) ? $item->office_id : '', ['class' => 'form-control select2','id'=>'office_id']) !!}
                           {!! $errors->first('office_id', '<p class="help-block text-danger">:message</p>') !!}
                       </div>
                    </div>
                    <div class="col-lg-6">
                       <div class="form-group">
                           {!! Form::label('store_id', 'Store Name') !!} 
                           {!! Form::select('store_id', [], isset($item) ? $item->store_id : '', ['class' => 'form-control select2','id'=>'store_id']) !!}
                           {!! $errors->first('store_id', '<p class="help-block text-danger">:message</p>') !!}
                       </div>
                    </div>

               </div>
              
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                    Submit
                                </button>
                                <a href={{route('user.index')}}>
                                    <button type="button" class="btn btn-secondary waves-effect">
                                        Cancel
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
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
        $(function () {
//multiple select
            $('#category').select2({
                placeholder: "Select Category"
            });
        });

        $('#office_id').change(function() {

           
            var office_id  = $('#office_id').find(':selected').val();
            

            if(office_id)  {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('store.getStore')}}",
                    data: {
                        office_id:office_id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        
                        $("#store_id").select2('destroy').empty().select2(
                        
                            { 
                            data: response.results
                            });
                    

                            setstorevalue();
                    }
                });
            }
           
            })

            @if(old('office_id') || isset($item))
                $('#office_id').trigger('change');
            @endif

            function setstorevalue() {

                
                let storeid = '';
                @if(old('store_id')) {
                    storeid ="{{old('store_id')}}";
                }
                @elseif(isset($item)) {
                    storeid ="{{ $item->store_id }}";
                }
                @endif

                console.log(" storeid =",storeid);
                $("#store_id").select2("val", storeid);
            }
           
    </script>
@endsection