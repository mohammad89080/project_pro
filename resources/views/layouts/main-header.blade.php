@php
    function time1($time)
    {
             $totalWorkedSeconds = $time ?? 0;

     $hours = floor($totalWorkedSeconds / 3600);
     $minutes = floor(($totalWorkedSeconds % 3600) / 60);
     $seconds = $totalWorkedSeconds % 60;


             return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

@endphp        
        
        <!--=================================
 header start-->

        <nav class="admin-header navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <!-- logo -->

            <div class="text-left navbar-brand-wrapper">

                @php
                  $settings=\App\Models\Settings::latest()->first();
                @endphp

                @if (empty($settings->logo))
                    <img class="rounded-circle" width="65" src="{{ URL::asset('assets/images/OSUS.jpg') }}" alt="logo">
                @else
                <img class="" width="60" src="{{ asset('assets/images/' . $settings->logo) }}" alt="logo">
                @endif

{{--                <a class="navbar-brand brand-logo-mini" href="index.html">--}}
            </div>
            <style>
                .navbar-brand-wrapper {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                /*.rounded-circle {*/
                /*    border-radius: 50%;*/
                /*}*/
            </style>
            <!-- Top bar left -->
            <ul class="nav navbar-nav mr-auto">
                <li class="nav-item">
                    <a id="button-toggle" class="button-toggle-nav inline-block ml-20 pull-left"
                        href="javascript:void(0);"><i class="zmdi zmdi-menu ti-align-right"></i></a>
                </li>
                <li class="nav-item">
                    <div class="search">
                        <a class="search-btn not_click" href="javascript:void(0);"></a>
                        <div class="search-box not-click">
                            <input type="text" class="not-click form-control" placeholder="Search" value=""
                                name="search">
                            <button class="search-button" type="submit"> <i class="fa fa-search not-click"></i></button>
                        </div>
                    </div>
                </li>
            </ul>

            @role('admin')
            @else
            <ul class="nav navbar-nav mr-auto">

                <li class="nav-item" id="tt">
                    <button class="btn btn-outline-primary" id="work-timer">00:00:00</button>
                </li>
            </ul>
            @endrole
            <!-- top bar right -->
            <ul class="nav navbar-nav ml-auto">
            <div class="btn-group mb-1">
                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if (App::getLocale() == 'ar')
                        {{ LaravelLocalization::getCurrentLocaleName() }}
                        <img src="{{ URL::asset('assets/images/flags/SA.png') }}" alt="">
                    @else
                        {{ LaravelLocalization::getCurrentLocaleName() }}
                        <img src="{{ URL::asset('assets/images/flags/US.png') }}" alt="">
                    @endif
                </button>
                <div class="dropdown-menu">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <ul class="nav navbar-nav ml-auto">
{{--                <li class="nav-item fullscreen">--}}
{{--                    <a id="btnFullscreen" href="#" class="nav-link"><i class="ti-fullscreen"></i></a>--}}
{{--                </li>--}}
                <li class="nav-item dropdown ">
                    <a class="nav-link top-nav" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ti-bell"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="badge badge-danger notification-status"> </span>
                        @endif

                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-big dropdown-notifications">
                        <div class="dropdown-header notifications">
                            <strong style="font-size: 15px">الإشعارات</strong>
                            <a href="{{route('MarkAsRead_all')}}" style="margin-right: 67px;background-color: #ffc300;
                                    font-size: 15px ;
                                    border-radius: 5px;
                                    padding: 2px ;">تعيين قراءة الكل</a>

                            <span class="badge badge-pill badge-warning" style="font-size: 15px"> {{ auth()->user()->unreadNotifications->count() }}</span>
                        </div>
                        <div class="dropdown-divider"></div>
                        @foreach (auth()->user()->unreadNotifications as $notification)
                        <a href="{{route('leave.index')}}" class="dropdown-item">{{ $notification->data['title'] }}
                            {{ $notification->data['user'] }} <small
                                class="float-right text-muted time cnotification-subtext" style="font-size: 15px" >{{ $notification->created_at }}</small> </a>

{{--                        <a href="#" class="dropdown-item">New invoice received <small--}}
{{--                                class="float-right text-muted time">22 mins</small> </a>--}}
{{--                        <a href="#" class="dropdown-item">Server error report<small--}}
{{--                                class="float-right text-muted time">7 hrs</small> </a>--}}
{{--                        <a href="#" class="dropdown-item">Database report<small class="float-right text-muted time">1--}}
{{--                                days</small> </a>--}}
{{--                        <a href="#" class="dropdown-item">Order confirmation<small class="float-right text-muted time">2--}}
{{--                                days</small> </a>--}}
                        @endforeach
                    </div>
                </li>
                <li class="nav-item dropdown ">
                    <a class="nav-link top-nav" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="true"> <i class=" ti-view-grid"></i> </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-big">
                        <div class="dropdown-header">
                            <strong>Quick Links</strong>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="nav-grid">
                            <a href="#" class="nav-grid-item"><i class="ti-files text-primary"></i>
                                <h5>New Task</h5>
                            </a>
                            <a href="#" class="nav-grid-item"><i class="ti-check-box text-success"></i>
                                <h5>Assign Task</h5>
                            </a>
                        </div>
                        <div class="nav-grid">
                            <a href="#" class="nav-grid-item"><i class="ti-pencil-alt text-warning"></i>
                                <h5>Add Orders</h5>
                            </a>
                            <a href="#" class="nav-grid-item"><i class="ti-truck text-danger "></i>
                                <h5>New Orders</h5>
                            </a>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown mr-30">
                    <a class="nav-link nav-pill user-avatar" data-toggle="dropdown" href="#" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="{{ URL::asset('assets/images/download.png') }}" alt="avatar">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header">
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="mt-0 mb-0">{{ Auth::user()->name }}</h5>
                                    <span>{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
{{--                        <a class="dropdown-item" href="#"><i class="text-secondary ti-reload"></i>Activity</a>--}}
{{--                        <a class="dropdown-item" href="#"><i class="text-success ti-email"></i>Messages</a>--}}
{{--                        <a class="dropdown-item" href="#"><i class="text-warning ti-user"></i>Profile</a>--}}
{{--                        <a class="dropdown-item" href="#"><i class="text-dark ti-layers-alt"></i>Projects <span--}}
{{--                                class="badge badge-info">6</span> </a>--}}
                        <div class="dropdown-divider"></div>
                        @role('admin')
                        <a class="dropdown-item" href="{{route('settings.index')}}"><i class="text-info ti-settings"></i>{{ trans('main_trans.Settings') }}</a>

                        @endrole
                        <a class="dropdown-item" href="#">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-transparent border-0" href="#"><i class="text-danger ti-unlock"></i>{{ trans('main_trans.Logout') }}</button>
                            </form>
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <!--=================================
 header End-->
