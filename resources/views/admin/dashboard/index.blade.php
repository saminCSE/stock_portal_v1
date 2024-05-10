@extends('layouts.master')

@section('css')
<style type="text/css">
  .main-content {
    background-color: #639aad33;
    height: 100vh;
  }

  .dashobard-watermark {
    position: absolute;
    top: 50%;
    left: 60%;
    transform: translateX(-50%) translateY(-50%);
    opacity: .2;
  }

  .dashobard-watermark img {
    height: 300px;
    width: 300px;
  }

  .dashboard-feature-single {
    padding: 30px;
    margin-bottom: 30px;
    border-radius: 5px;
    position: relative;
    height: 150px;
    overflow: hidden;
  }

  .row .col-sm-4:nth-child(1n) .dashboard-feature-single {
    background: #f56954;
  }

  .row .col-sm-4:nth-child(2n) .dashboard-feature-single {
    background: #00a65a;
  }

  .row .col-sm-4:nth-child(3n) .dashboard-feature-single {
    background: orange;
  }

  .row .col-sm-4:nth-child(4n) .dashboard-feature-single {
    background: purple;
  }

  .row .col-sm-4:nth-child(5n) .dashboard-feature-single {
    background: #00a6cf;
  }

  .row .col-sm-4:nth-child(6n) .dashboard-feature-single {
    background: #00639e;
  }

  .dashboard-feature-single .svg-inline--fa {
    height: 90px;
    width: 90px;
    font-size: 30px;
    border-radius: 50px;
    color: #000000;
    margin: auto;
    display: block;
    padding: 15px;
    position: absolute;
    right: 0;
    opacity: .1;
    bottom: -10px;
    padding: 0;
  }

  .dashboard-feature-single h3 {
    color: #ffffff;
    font-size: 50px;
    font-weight: bold;
    line-height: 1;
  }

  .dashboard-feature-single p {
    color: #ffffff;
    font-size: 22px;
  }
</style>
<!-- datatables css -->
<link href="{{ URL::asset('assets/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="dashobard-watermark">
  <img class="" src="{{asset('assets/images/watermark_logo.jpg')}}" alt="Header Avatar">
</div>

<br>
<div class="dashboard-feature">
  <div class="row">
    @php
    $server_1 = config('siteconfig.server_1');
    $server_2 = config('siteconfig.server_2');
    $token = '';
    @endphp


    <div class="col-sm-4">
      <a href="#">
        <div class="dashboard-feature-single">
          <i class="fa fa-id-card"></i>
          <h3></h3>
          <p></p>
        </div>
      </a>
    </div>
    <div class="col-sm-4">
      <a href="#">
        <div class="dashboard-feature-single">
          <i class="fa fa-graduation-cap"></i>
          <h3></h3>
          <p></p>
        </div>
      </a>
    </div>
    <div class="col-sm-4">
      <a href="#">
        <div class="dashboard-feature-single">
          <i class="fa fa-anchor"></i>
          <h3></h3>
          <p></p>
        </div>
      </a>
    </div>

  </div>
</div>

@endsection

@section('script')

<!-- Plugins js -->
<script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
<script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js')}}"></script>


<script>

</script>

@endsection
