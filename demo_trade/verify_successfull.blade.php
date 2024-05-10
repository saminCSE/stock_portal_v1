@extends('layouts.demo_master')
@section('content')
    <main>

        <div style="height: 150px" class="demo_section main-slider">
            <div style="height: 150px" class="container main-slider__container">
                <div class="main-slider__bg bg">
                    <div class="bg__item bg__item_gradient"></div>
                </div>
                <div style="height: 150px" class="content main-slider__content">
                    <div style="min-height: 150px;padding:0;transform: translateY(60px);" class="main-slider__in">
                        <h3 style="margin-bottom: 0px;" class="" style=""></h3>
                        <div class="main-slider__desc">

                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="main_panel" style="height: calc(100vh - 150px); position:relative">
            <div class="content-container"
                style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%); text-align:center">
                <h2 class="text-center">Registration confirmed, welcome to Sheba Capital Ltd!</h2>
                <p class="text-center mt-3" style="font-size: 20px">Your account is successfully verified, and you are
                    eligible to participate in our contests.</p>
                <h4 class="mb-3">Enjoy Trading</h4>
                <a href="{{ route('demotrading') }}" class="enroll-btn" style="text-decoration: none">Visit Our Site</a>
            </div>
        </div>

    </main>
@endsection
