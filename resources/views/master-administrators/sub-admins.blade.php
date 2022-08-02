@extends('layout.default')
@section('title')
{{ config('app.name') }} | Command Centers - Sub Admins
@stop
@section('css')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="{{ url('/public') }}/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="{{ url('/public') }}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
@stop
@section('page-content')
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE TITLE-->
      {{--
      <h1 class="page-title">
         <small></small>
      </h1>
      --}}
      <!-- END PAGE TITLE-->
      <div class="page-bar">
      </div>
      <div class="row" style="margin-top: 3%">
         <div class="col-md-12">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet light bg-inverse">
               <div class="portlet-title">
                  <div class="caption font-green-sharp">
                     <i class="icon-speech font-green-sharp"></i>
                     <span class="caption-subject"> Command Centers | Sub Admins</span>
                     {{-- <span class="caption-helper"></span> --}}
                  </div>
                  <div class="actions">
                     <a class="btn btn-circle btn-icon-only red fullscreen" href="javascript:;"><i class="icon-size-fullscreen"></i> </a>
                  </div>
               </div>
               <div class="portlet-body">
                  {{-- <div class="scroller" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd"> --}}
                     <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered table-hover">
                           <thead>
                              <tr>
                                <th style="display: none">Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>

                            </tr>
                           </thead>
                           <tbody>
                              @php $i = 1; @endphp
                                    @foreach($subadmins as $admin)
                                    <tr>
                                        <td style="display: none">{{$admin->id}}</td>
                                        <td >{{$admin->name}}</td>
                                        <td >{{$admin->email}}</td>
                                        <td >{{$admin->created_at}}</td>
                                    </tr>
                                @endforeach
                                @php $i++; @endphp
                            </tbody>
                        </table>
                     </div>
                     {{-- {{ $subadmins }} --}}
                  {{-- </div> --}}
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- END CONTENT BODY -->
</div>

@stop
@section('scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{url('public')}}/assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="{{url('public')}}/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="{{url('public')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="{{url('public')}}/assets/pages/scripts/table-datatables-responsive.min.js" type="text/javascript"></script>
<script type="text/javascript">
   $(document).ready(function(){
        $.fn.dataTable.ext.errMode = 'none';
       // var table = $('#sample_2').dataTable();
       // table.buttons('.buttonsToHide').nodes().css("display", "none");
   })


</script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- END PAGE LEVEL SCRIPTS -->

<script>

    $(function () {
       $('#example2').DataTable({
           "aaSorting": [],
           "sPaginationType": "full_numbers",
           "DisplayLength" : 20,
           'paging'      : true,
           'searching'   : true,
           'ordering'    : true,
           'info'        : true,
           'autoWidth'   : false,
           "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            "language": {
                            "sLengthMenu": "_MENU_ Records",
                            "search": "Search  ",
                        }
       })
    })



</script>
<style>
    ul.pagination li {
        display: inline;
        font-size: 12px;
        font-weight: bold;
    }

    ul.pagination li a {

        color: black;
        text-decoration: none;
        transition: background-color .3s;
        border: 1px solid #ddd;
            margin: 0;
    }

    ul.pagination li a.active {
        background-color: #047dc4;
        /*padding: 10px 15px;*/
        /*margin: 4px;*/
        color: white;
        border: 1px solid #047dc4;
    }

    ul.pagination li.active {
        /*background-color: #4CAF50;*/
        background-color: #047dc4;
        /*padding: 10px 15px;*/
        /*margin: 4px;*/
        color: white;
        border: 1px solid #047dc4;
    }

    /*ul.pagination li a:hover:not(.active) {background-color: #ddd;}*/
    ul.pagination li a:hover {background-color: #999999;}
    .dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0 0;
}
 #example2_paginate > ul > li.paginate_button.active:hover {
    background: transparent !important;
    border: none !important;
}
    ul.pagination li.disabled {
        /*background-color: #cccccc;*/
        color: #ddd;
        padding: 10px 15px;
        border: 1px solid #ddd;
        margin: 4px;
    }
     table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
         display: none !important;
     }
     .dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0 !important;
        margin: 2px;
    }

@media screen and (max-width: 768px){

    .table div.dropdown-menu {
    width: 165px;
    right: 0px;
    z-index: 99999;
    position: relative;
    top: auto;
}
 .table button#action {
    margin-left: 80px;
    margin-top: -35px;
}
}


</style>

@stop