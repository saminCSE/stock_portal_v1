@php
    $title = '';
    $action = '';

    $route = Route::currentRouteName();



    if ($route) {

        $routeArray = explode('.', $route);

        if(count($routeArray) > 1) {
            list($title, $action) = $routeArray;
        }
        else {
            $route = false;
        }

    }
    $ignore = ["dsedData","instrument","ipo","newscategory","login","ChangeMarketScheduler","csvFileImport","company_agm","ChangeMarketSchedulerdata","dailyData","DataEod","book","review","settings","market"];
@endphp
<!-- start page title -->

@if($route && !in_array($title, $ignore))
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
{{--                <h4 class="font-size-18">--}}
{{--                    <a href={{url('/')}}>{{ucfirst(config('siteconfig.adminRoute'))}}</a>--}}
{{--                </h4>--}}
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href={{route($title.'.'.'index')}}>{{ucfirst($title)}}</a></li>
                    <li class="breadcrumb-item active"><a>{{ucfirst($action)}}</a></li>
                </ol>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
                @if($action === 'index')
                    @php
                        $permission_check_str = $title.' create';
                    @endphp

                   {{--  @if(Auth()->user()->can($permission_check_str))--}}
                    <a href={{route($title.'.'.'create')}}>
                        <button class="btn btn-primary waves-effect waves-light" type="button" id="pagetopaddaction">
                            <i class="ti-plus mr-2"></i> {{config('siteconfig.Add')}}
                        </button>
                    </a>
                    {{-- @endif--}}
                @else
                    <a href={{route($title.'.'.'index')}}>
                        <button class="btn btn-success waves-effect waves-light" type="button">
                            <i class="fas fa-arrow-alt-circle-left"></i> &nbsp;{{config('siteconfig.Back')}}
                        </button>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
<!-- end page title -->
