<!-- ========== Left Sidebar Start ========== -->
@php
    $session = session()->get('LoggedUser');
    $token = $session['token'];
@endphp

<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->

            <!-- @php
                echo sidebarhtml();
            @endphp  -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="#" class="waves-effect">
                        <i class="ti-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('bolist')}}" class="waves-effect">
                        <i class="ti-user"></i>
                        <span>Benificiary Owners</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fab fa-palfed"></i>
                        <span>Market Scheduler</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('marketscheduler.index') }}">Scheduler Data</a></li>
                        <li><a href="{{ url(config('siteconfig.adminRoute') . '/marketscheduler/1/edit') }}">Scheduler
                                Settings</a></li>
                        <li><a href="{{ route('ChangeMarketScheduler.edit') }}">Change Scheduler</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fab fa-palfed"></i>
                        <span>Trade Data</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li> <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fab fa-palfed"></i>
                                <span>Daily Data</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('dsedData.intradata') }}">Daily Data List</a></li>
                                <li><a href="{{ route('dailyData.create') }}">Add Daily Data</a></li>
                            </ul>
                        </li>
                        <li> <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fab fa-palfed"></i>
                                <span>Data Bank</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('dsedData.intradataeod') }}">Data Eod List</a></li>
                                <li><a href="{{ route('DataEod.create') }}">Add Data EOd</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('dsedData.intradataeod') }}">EOD Data </a></li>
                        <li><a href="{{ route('dsedData.indexData') }}">Index Value </a></li>
                        <li><a href="{{ route('market.list') }}">Market Data </a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fab fa-palfed"></i>
                        <span>Instrument</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('instrument.list') }}">Instrument List </a></li>
                        <li><a href="{{ route('instrument.create') }}">Create Instrument </a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fab fa-palfed"></i>
                        <span>IPO</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('ipo.list') }}">Manage Ipo </a></li>
                        <li><a href="{{ route('ipo.create') }}">Create Ipo </a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fab fa-palfed"></i>
                        <span>News</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('newscategory.category_create') }}">News Category</a></li>
                        <li><a href="{{ route('newsportal.create') }}">Create News</a></li>
                        <li><a href="{{ route('newsportal.index') }}">News List </a></li>
                    </ul>

                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fab fa-palfed"></i>
                        <span>News Letter</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('newsletter.index') }}">List </a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fab fa-palfed"></i>
                        <span>Announcement</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('announce_list') }}">Announcement List</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fab fa-palfed"></i>
                        <span>Company</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <span>Comapny Information</span>
                            </a>

                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('company_list') }}"> Market List</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <span>Basic Information</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('company_basic_info') }}"> basic Information</a></li>
                                <li><a href="{{ route('create_company_basic_info') }}"> Add Basic Info</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <span>Last AGM Information </span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('company_agm') }}">AGM Information List</a></li>
                                <li><a href="{{ route('company_agm.create') }}"> Add AGM Information </a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <span>Interim Financial Performance </span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('company_interim.index') }}">Interim Financial Performance
                                        List</a></li>
                                <li><a href="{{ route('company_interim.create') }}"> Add Interim Financial Performance
                                    </a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-th"></i>
                        <span>Company Financial Statement</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('company_financial_statement.index') }}">Manage Company Financial Statement</a></li>
                        <li><a href="{{ route('company_financial_statement.create') }}">Add Company Financial Statement</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-th"></i>
                        <span>Block Transaction</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('blocktransaction.index') }}">Manage Block Transaction</a></li>
                        <li><a href="{{ route('blocktransaction.create') }}">Add Block Transaction</a></li>
                        <li><a href="{{ route('csvFileImport.blockTrasactionupload') }}">Block Transaction CSV
                                Upload</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-user-secret"></i>
                        <span>Designations</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('designation.index') }}">Manage Designation</a></li>
                        <li><a href="{{ route('designation.create') }}">Add Designation</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-suitcase"></i>
                        <span>Director Profile</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('director_profile.index') }}">Manage Director Profile</a></li>
                        <li><a href="{{ route('director_profile.create') }}">Add Director Profile</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-suitcase"></i>
                        <span>Company Board Of Directors</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('company_director.index') }}">Manage Company Board Of Directors</a></li>
                        <li><a href="{{ route('company_director.create') }}">Add Company Board Of Directors</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-book"></i>
                        <span>Books</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('book.list') }}">Manage Books</a></li>
                        <li><a href="{{ route('book.create') }}">Add Books</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-star"></i>
                        <span>Reviews</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('review.list') }}">Manage Reviews</a></li>
                        <li><a href="{{ route('review.create') }}">Add Reviews</a></li>
                    </ul>
                </li>
                <li>
                    <a href={{ route('csvFileImport.eodupload') }} class="waves-effect">
                        <i class="ti-home"></i>
                        <span>CSV Upload For EOD</span>
                    </a>
                </li>
                <li class="menu-title">Demo Trade</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-suitcase"></i>
                        <span>Contest User Type</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('contest_user_type.index') }}">Manage Contest User Type</a></li>
                        <li><a href="{{ route('contest_user_type.create') }}">Add Contest User Type</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-suitcase"></i>
                        <span>Contest Type</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('contest_type.index') }}">Manage Contest Type</a></li>
                        <li><a href="{{ route('contest_type.create') }}">Add Contest Type</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-suitcase"></i>
                        <span>Contest</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('contest.index') }}">Manage Contest</a></li>
                        <li><a href="{{ route('contest.create') }}">Add Contest</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-suitcase"></i>
                        <span>Contest Organizer</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('contest_organizer.index') }}">Manage Contest Organizer</a></li>
                        <li><a href="{{ route('contest_organizer.create') }}">Add Contest Organizer</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-suitcase"></i>
                        <span>Contest Prize</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('prize.index') }}">Manage Contest Prize</a></li>
                        <li><a href="{{ route('prize.create') }}">Add Contest Prize</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-suitcase"></i>
                        <span>Contest Video</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('contest_video.index') }}">Manage Contest Video</a></li>
                        <li><a href="{{ route('contest_video.create') }}">Add Contest Video</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-suitcase"></i>
                        <span>Commission</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('commission.index') }}">Manage Commission</a></li>
                        <li><a href="{{ route('commission.create') }}">Add Commission</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-suitcase"></i>
                        <span>Api Access Key</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('apiAccess_list') }}">Manage Access</a></li>
                        <li><a href="{{ route('apiAccess_create') }}">Add Access</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('settings.edit') }}" class=" waves-effect">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path fill="currentColor" d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Left Sidebar End -->
