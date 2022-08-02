@extends('layout.default')
@section('title')
    {{ config('app.name') }} - Dashboard
@stop
@section('page-content')

@php
// set url
    $url = url('/') . "/master-hub";
    $value = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

@endphp

<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->

        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb ">
                <li>
                    <a href="{{$url}}/dashboard">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Dashboard</span>
                </li>
            </ul>
        </div>
         <div class="account-details">
                  <p class="user">

                {{-- <span id="usr-nm">{{ $name }}</span><span id="usr-ml">{{ $email }}</span> --}}
               </p>
                </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <div class="row" >
            <div class="col-lg-10 col-md-3 col-sm-6 col-xs-12">

        <h1 class="page-title" style="height: 10px"> </h1>

            </div>
            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 pull-right">
            {{-- <img src="{{ asset('public/images/logo.png') }}" style="width: 140px; height: 60px; margin-top: 4px"> --}}

            </div>
        </div>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <!-- BEGIN DASHBOARD STATS 1-->
        @php
            $user = session('admin.0');

            if ($user['user_type'] == 1) {
                $admins = \App\Admin::where('parent_id', $user['id'])->where('user_type', 2)->count();
            } else {
                $admins = \App\Admin::where('parent_id', $user['id'])->where('user_type', 2)->count();
            }
            $users = \App\Users::where('admin_id', $user['id'])->count();
            $admins = \App\Admin::where('user_type', 3)->count();
            $contact_centers = \App\Organizations::where('admin_id', $user['id'])->where('type', 1)->count();

        @endphp


        <div class="row">


            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 red new-orange" href="{{ $url }}/organization">
                    <div class="visual">
                        <i class="icon-globe"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{ $contact_centers }}">0</span></div>
                        <div class="desc uppercase"> Admin Centers </div>
                    </div>
                </a>
            </div>

            @php
                $user_type = 3;
                if(session::has('admin')){
                    $user_type = session('admin.0.user_type');
                }

                if($user_type == 1){


            @endphp

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 blue" href="javascript:void(0)">
                    <div class="visual">
                        <i class="icon-users"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{ $admins }}">0</span>
                        </div>

                        <div class="desc uppercase"> Command Centers </div>
                    </div>
                </a>
            </div>

            @php
                }else{

            @endphp
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 blue" href="javascript:void(0)">
                    <div class="visual">
                        <i class="icon-user"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{ $users }}">0</span>
                        </div>

                        <div class="desc uppercase"> Users </div>
                    </div>
                </a>
            </div>
            @php
                }
            @endphp


        </div>
        <div class="clearfix"></div>
        <!-- END DASHBOARD STATS 1-->


    </div>
    <!-- END CONTENT BODY -->
</div>

<!-- END CONTENT -->
 <!-- BEGIN PAGE LEVEL SCRIPTS -->
@stop