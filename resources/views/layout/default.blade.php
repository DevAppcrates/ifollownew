
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head id="head">
<meta charset="utf-8" />
<title>@yield('title')</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta content="" name="description" />
<meta name="csrf_token" content="{{ csrf_token() }}">
<meta content="" name="author" />
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />


<link href="{{ asset('public/assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}"  rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/css/material.css') }}" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="{{ asset('public/assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
<link href="{{ asset('public/assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->
<link href="{{ asset('public/assets/layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/layouts/layout/css/themes/blue.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
<link href="{{ asset('public/assets/layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
 <link href="{{ asset('public/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
  {{-- <link href="{{ asset('public/scripts/css/darkblue.min.css') }}" rel="stylesheet"> --}}
<link href="{{ asset('public/scripts/css/toastr.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/css/custom-css.css') }}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" media="screen" href="{{ url('/') }}/public/js/dropdown-ui/css/multi-select.css">

<style type="text/css">


</style>

@yield('css')
<!-- END THEME LAYOUT STYLES -->
{{-- <link rel="shortcut icon" href="favicon.ico" />  --}}
</head>
<!-- END HEAD -->

<body  class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">

    <?php $url = url('/') . "";?>


    <div class="page-wrapper">
    <!-- BEGIN HEADER -->
    <div id="top-nav" class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
    <!-- BEGIN LOGO -->
    <div class="page-logo">
    <a href="{{$url}}/dashboard">
    <img src="{{ asset('public/images/logo@3x.png') }}" alt="logo" class="logo-default logo-css" />
    </a>
    <div class="menu-toggler sidebar-toggler " >
    <span></span>
    </div>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
    <span></span>
    </a>
    <!-- END RESPONSIVE MENU TOGGLER -->
    <!-- BEGIN TOP NAVIGATION MENU -->

    @php

    if (Session::has('admin')) {
        $user = Session::get('admin');
        $email = $user[0]['email'];
        $name = $user[0]['name'];
        $user_type = $user[0]['user_type'];
    }

    @endphp

    <div class="top-menu">
        <span id="top-current-time"><span id="current-time"></span></span>
    <ul class="nav navbar-nav pull-right">

    <li class="dropdown dropdown-user">

        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <i class="img-circle icon-user" ></i>
            <span class="username username-hide-on-mobile"> {{ session('admin')[0]['email'] }}  </span>
            <i class="fa fa-angle-down"></i>
        </a>
        <ul id="dashboard-dropdown" class="dropdown-menu dropdown-menu-default">
            <li>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#changePasswordAdminModal" >
                    <i class="icon-pencil"></i> Change Password </a>
            </li>

            <li class="divider"> </li>

            @php
                 if(session('admin.0.user_type') == 3){
            @endphp
            <li>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#edit_master_admin" class="nav-link ">
                    <i class="icon-user"></i>
                    <span class="title">Profile</span>
                </a>
            </li>

            <li class="divider"> </li>

            @php
              }
            @endphp
            <li>
                <a href="javascript:void(0)" onclick="adminLogout()" >
                    <i class="icon-key"></i> Log Out </a>
            </li>
        </ul>
    </li>
    </ul>
    </div>
    <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
                {{-- @if(Session::has('admin') && Request::segment(2) != 'change') --}}
                	@include('layout.sidebar')
      			{{-- @endif --}}

                @yield('page-content')

    </div>
    <!-- END CONTAINER -->
    </div>



        <!-- Bootstrap Material Design JavaScript -->
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/material.js"></script>
<!-- Bootbox -->
<script type="text/javascript" src="{{url('/')}}/public/js/bootbox.js"></script>

<!-- ezdz -->
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/jquery.ezdz.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/jquery.min.js"></script>

<!-- tag -->
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/tag-input.min.js"></script>
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/dropdown-ui/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/dropdown-ui/jquery.quicksearch.js"></script>

<!-- Jasny  js  -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
<script src="{{ url('public/') }}/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="{{ url('public/') }}/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
<!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ url('public/') }}/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
 <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{ url('public/') }}/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="{{ url('public/') }}/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="{{ url('public/') }}/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="{{ url('public/') }}/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        @include('modals')
        @include('scripts')
        <script type="text/javascript">
          $(document).ready(function(){

    $('#users').multiSelect({
          selectableOptgroup: true,

      selectableHeader: "<a href='#' id='select-all'>Select All</a><br/><span><small style='padding-left:2px; color:#2d5f8b;'>Click A User To Add To This Group Above.</small></span><input type='text' class='search-input form-control btn-circle' autocomplete='off' placeholder='Search by Name or Tag'>",
  selectionHeader: "<a href='#' id='deselect-all'>Deselect All</a><br/><span><small style='padding-left:2px; color:#2d5f8b;'>Click A User To Delete From This Group.</small></span><input type='text' class='search-input form-control btn-circle' autocomplete='off' placeholder='Search to Deselect'>",
          afterInit: function(ms){

              var that = this,

                  $selectableSearch = that.$selectableUl.prev(),
                  $selectionSearch = that.$selectionUl.prev(),
                  selectableSearchString = '#'+that.$container.attr('id')+'  .ms-elem-selectable:not(.ms-selected)',
                  selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

              that.qs1 = $selectableSearch.quicksearch(selectableSearchString,{
                  'show': function () {
                     // alert('show');
                      $(this).prev(".ms-optgroup-label").show();
                      $(this).show();
                  },
                  'hide': function () {
                  //    alert('hide');
                      $(this).prev(".ms-optgroup-label").hide();
                      $(this).hide();
                  }
              })
                  .on('keydown', function(e){
                      if (e.which === 40){
                          that.$selectableUl.focus();
                          return false;
                      }
                  });

              that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                  .on('keydown', function(e){
                      if (e.which == 40){
                          that.$selectionUl.focus();
                          return false;
                      }
                  });
          },


  afterSelect: function(){
    this.qs1.cache();
    this.qs2.cache();
  },
  afterDeselect: function(){
    this.qs1.cache();
    this.qs2.cache();
  }
    });
  })
  $(document).on('click','#select-all',function(){
  $('#users').multiSelect('select_all');
  return false;
});
$(document).on('click','#deselect-all',function(){
  $('#users').multiSelect('deselect_all');
  return false;
});
// Custom scrollbar init
var el = document.querySelector('.custom-scrollbar');
Ps.initialize(el);
</script>

<!-- Toastr Script -->
<script>
toastr.options = {
"closeButton": true, // true/false
"debug": false, // true/false
"newestOnTop": false, // true/false
"progressBar": false, // true/false
"positionClass": "toast-top-right", // toast-top-right / toast-top-left / toast-bottom-right / toast-bottom-left
"preventDuplicates": false,
"onclick": null,
"showDuration": "2000", // in milliseconds
"hideDuration": "1000", // in milliseconds
"timeOut": 0, // in milliseconds
"extendedTimeOut": 0, // in milliseconds
"showEasing": "swing",
"hideEasing": "linear",
"showMethod": "fadeIn",
"hideMethod": "fadeOut"
}
</script>
<script src="{{ asset('public/scripts/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/scripts/js/components-select2.min.js') }}" type="text/javascript"></script>
<!-- Latest compiled and minified JavaScript -->
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/dropdown-ui/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/dropdown-ui/jquery.quicksearch.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@yield('scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN" : $('meta[name="csrf_token"]').attr('content'),
        },
        cache: false
    });

    $(document).ready(function(){
        $( "#datepicker" ).datepicker({
          showButtonPanel: true,
           "showAnim" : 'slideDown',
           "dateFormat":'mm/dd/yy',
        });
        $( "#edit_datepicker" ).datepicker({
          showButtonPanel: true,
           "showAnim" : 'slideDown',
           "dateFormat":'mm/dd/yy',
        });
        $('#send_push #schedule_dropdown').change(function(){
          $('#add-MN-schedule').toggle();
        });
        $('#edit_push #schedule_dropdown').change(function(){
          $('#schedule').toggle();
        });
    });
    function updateTemplate(){
            title = $('input[name="title"]').val()
            notification = $('textarea[name="notification"]').val()
            if(title == '' && notification == ''){
              $('#getTemplateDropdown').val($("#getTemplateDropdown option:first").val());
            }
        }
</script>

<script>
// var myVar = setInterval(myTimer, 1000);

// function myTimer() {
//     var d = new Date();
//     var t = d.toLocaleTimeString('en-US',{timeZone:'{{session('contact_center_admin.0.time_zone.timezone_code')}}'});
//     document.getElementById("current-time").innerHTML = t;
// }


</script>

    </body>

    </html>