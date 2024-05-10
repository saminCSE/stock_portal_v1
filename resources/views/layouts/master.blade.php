<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
     <title>{{$setting->brand_name}} | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
     <link rel="shortcut icon" href="{{asset($setting->favicon)}}">
     <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    @include('layouts.head')
</head>
<body class="vertical" data-sidebar="dark">
<div id="loader">
    <p style="position: absolute; color: White; top: 50%; left: 45%;">
        <img src='{{asset('/assets/images/loading.gif')}}'>
    </p>
</div>

@section('body')
@show
<div id="preloader">
    <div id="status">
        <div class="spinner-chase">
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
        </div>
    </div>
</div>
<!-- Begin page -->
<div id="layout-wrapper">
@include('layouts.topbar')
@include('layouts.sidebar')
<!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @include('layouts.message-error')
                @include('layouts.brade-curmbs')
                @yield('content')
                @yield('market')
                
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('layouts.footer')
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
@include('layouts.right-sidebar')
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- JAVASCRIPT -->
@include('layouts.footer-script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
