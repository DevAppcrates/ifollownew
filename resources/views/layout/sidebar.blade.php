 <!-- BEGIN SIDEBAR -->
@php

    $path = basename(Request::url());
    $url = url('/') . "/master-hub/";
    $value = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

    if (Session::has('admin')) {
        $user = Session::get('admin');
        $email = $user[0]['email'];
        $name = $user[0]['name'];
        $user_type = $user[0]['user_type'];
    }

@endphp

    <div class="page-sidebar-wrapper">

        <div class="page-sidebar navbar-collapse collapse">

            <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200" data-style='red'>

                <li class="nav-item start{{ ($path == 'dashboard')?'active':'' }}">
                    <a href="{{$url}}dashboard" class="nav-link">
                        <i class="fa fa-home"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                       <i class="fa fa-globe"></i>
                        <span class="title">Admin Centers</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item {{ ($path == 'organization')?'active':'' }}">

                            <a href="#" data-toggle="modal" data-target="#add_contact_center" class="nav-link waves-effect">
                                <i class="icon-users"></i>
                                <span class="title">Add Admin Center</span>
                            </a>
                        </li>

                        <li class="nav-item  {{ ($path == 'organization')?'active':'' }}">
                            <a href="{{$url}}organization" class="nav-link">
                                <i class="icon-users"></i>
                                <span class="title">List Of All Admin Centers</span>
                            </a>
                        </li>
                    </ul>
                </li>

                 @php
                   if(session('admin.0.user_type') != 2){
                @endphp

                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                       <i class="fa fa-user"></i>
                        <span class="title">Master Sub Admins</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item {{ ($path == 'administrators')?'active':'' }}">

                            <a href="#" data-toggle="modal" data-target="#add_admin" class="nav-link waves-effect">
                                <i class="icon-users"></i>
                                <span class="title">Add Master Sub Admin</span>
                            </a>
                        </li>

                        <li class="nav-item  {{ ($path == 'administrators')?'active':'' }}">
                            <a href="{{$url}}administrators" class="nav-link ">
                                <i class="icon-users"></i>
                                <span class="title">List Of Master Sub Admins</span>
                            </a>
                        </li>
                    </ul>
                </li>

                @php
                    }
                    // dd(session('admin'));
                    if(session('admin.0.user_type') == 1){
                @endphp

                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                       <i class="icon-users"></i>
                        <span class="title">Command Centers</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item {{ ($path == '')?'active':'' }}">

                            <a href="#" data-toggle="modal" data-target="#add_master_admin" class="nav-link waves-effect">
                                <i class="icon-users"></i>
                                <span class="title">Add Command Center</span>
                            </a>
                        </li>

                        <li class="nav-item  {{ ($path == 'master-administrations')?'active':'' }}">
                            <a href="<?php echo url('/') ?>/master-hub/master-administrations" class="nav-link ">
                                <i class="icon-users"></i>
                                <span class="title">List Of Command Centers</span>
                            </a>
                        </li>
                    </ul>
                </li>

                @php
                   }
                   if(session('admin.0.user_type') != 3 && session('admin.0.refferenced_sub_admin') == 'admin'){
                @endphp


                <li class="nav-item {{ ($path == 'list-of-monitors')?'active':'' }}">
                    <a href="<?php echo url('/') ?>/master-hub/list-of-monitors" class="nav-link ">
                        <i class="icon-users"></i>
                        <span class="title">List Of All Monitors</span>
                    </a>
                </li>


                @php
                    }
                   if(session('admin.0.user_type') != 1 && session('admin.0.refferenced_sub_admin') != 'admin' ) {
                @endphp

                <li class="nav-item {{ ($path == 'monitors')?'active':'' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                       <i class="icon-users"></i>
                        <span class="title">Monitors</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item">

                            <a href="#" data-toggle="modal" data-target="#add_monitor" class="nav-link waves-effect">
                                <i class="icon-users"></i>
                                <span class="title">Add Monitor</span>
                            </a>
                        </li>

                        <li class="nav-item  {{ ($path == 'organization')?'active':'' }}">
                            <a href="{{$url}}monitors" class="nav-link ">
                                <i class="fa fa-globe"></i>
                                <span class="title">List Of All Monitors</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- <li class="nav-item">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#edit_master_admin" class="nav-link ">
                        <i class="icon-user"></i>
                        <span class="title">Profile</span>
                    </a>
                </li> --}}

                @php
                   }
                @endphp


                <li class="nav-item">
                    <a href="#" onclick="adminLogout()" class="nav-link">
                        <i class="fa fa-sign-out"></i>
                        <span class="title">Logout</span>
                    </a>
                </li>

        </div>
        <!-- END SIDEBAR -->
    </div>
    <!-- END SIDEBAR -->

