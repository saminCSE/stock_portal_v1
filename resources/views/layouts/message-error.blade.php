@if(session()->has('message'))
 <div class="alert alert-success alert-dismissable">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>{{ session()->get('message') }}</strong>
 </div>
@endif
@if(session()->has('error'))
 <div class="alert alert-danger alert-dismissable">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    @if(is_array(session()->get('error')))
        <div class="alert alert-danger">
            <ul>
                @foreach (session()->get('error') as $error)
                    <li>{{ $error }}</li> 
                @endforeach
            </ul>
        </div>
    @else
        <strong>{{ session()->get('error') }}</strong>
    @endif 
 </div>
@endif
{{--{{dd($errors)}}--}}
@if (count($errors) > 0)
 <div class="alert alert-danger">
  <ul>
   @foreach ($errors->all() as $error)
    <li>{{ $error }}</li> 
   @endforeach
  </ul>
 </div>
@endif