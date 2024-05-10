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
           
            {!! Form::open(['route' => ["permissionrole.update",$id], 'method'=>'PUT', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
           
            <form class="custom-validation" action="#">
              
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('role_id', 'Role') !!} 
                            {!! Form::select('role_id', $role, isset($item[0]['role_id']) ?$item[0]['role_id'] : NULL, ['class' => 'form-control','disabled'=>'true']) !!}
                            {!! $errors->first('role_id', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <input type="hidden" value="1" name="userid" />
                    <input type="hidden" value="{{$item[0]['role_id']}}" name="roleid"  />
                
                </div>
                <div class="row">
                {{-- <!-- @if(old('userid'))
                    @foreach(old('menu_id') as $key => $value)
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="menu_id[{{$value}}]" value="{{$value}}" /> {{ old("menutext_name.$value")}}
                                    <input type="hidden" name="menutext_id[{{$value}}]" value="{{$value}}" />
                                    <input type="hidden" name="menutext_name[{{$value}}]" value='{{old(old("menutext_name.$value"))}}' /> 
                                </label>
                            </div>
                        </div>


                    @endforeach
                @else --> --}}

                <div class="col-md-12">
                    <div class="checkbox">
                        <label>
                           
                        <input type="checkbox" name="all_chk" onclick="$('input[name*=\'permission_id\']').prop('checked', this.checked);"> All Check
                    
                        </label>
                    </div>
                </div>
                
                    @foreach($permission as $key=>$value)
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="permission_id[{{$value->id}}]" value="{{$value->id}}" {{$value->is_selected == 1?'checked':''}}/> {{ $value->label_name }}
                                    <input type="hidden" name="permissiontext_id[{{$value->id}}]" value="{{$value->id}}" />
                                    <input type="hidden" name="permissiontext_name[{{$value->id}}]" value="{{$value->label_name}}" /> 
                                </label>
                            </div>
                        </div>

                      
                    @endforeach
               {{--  <!-- @endif --> --}}
                </div>
             
               
             
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                    Submit
                                </button>
                                <a href={{route('permissionrole.index')}}>
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
     $('.datepicker').datepicker({
                autoclose:true,
                todayHighlight:true,
                format:'yyyy-mm-dd',
            });
    </script>
@endsection