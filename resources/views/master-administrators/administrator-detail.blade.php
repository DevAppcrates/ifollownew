@extends('layout.default')
@section('title')
{{ config('app.name') }} | Command Center - Admin Centers
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
  <style type="text/css">
    #admin-detail-table table th{
      width: 500px !important;
    }
    #admin-detail-table table{
      border: none !important;
    }
  </style>
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
                     <span class="caption-subject"> Command Center | Admin centers </span>
                     {{-- <span class="caption-helper"></span> --}}
                  </div>
                  <div class="actions">
                     <a class="btn btn-circle btn-icon-only red fullscreen" href="javascript:;"><i class="icon-size-fullscreen"></i> </a>
                  </div>
               </div>
               <div class="portlet-body">


{{--

    "mailing_st" => "99 Mott st"
    "mailing_city" => "Miami"
    "mailing_state" => "FLorida"
    "mailing_zip_code" => "33126"

    "number_of_admin_centers" => 50
    "allow_no_of_users_in_cc" => 200

    --}}


                <div class="row" style="margin-top: 3%">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <div style="padding: 10px; margin-bottom: 20px" id='admin-detail-table'>

                      <table>
                        <tr>
                          <th>First Name</th>
                          <td>{{ $admin_detail->name }}</td>
                          <th>Last Name</th>
                          <td>{{ $admin_detail->last_name }}</td>
                          <th>Title</th>
                          <td>{{ $admin_detail->title }}</td>
                        </tr>
                        <tr>
                          <th>Business Name</th>
                          <td>{{ $admin_detail->business_name }}</td>
                          <th>Business Type</th>
                          <td>{{ $admin_detail->business_type }}</td>
                          <th>Email</th>
                          <td>{{ $admin_detail->email }}</td>

                        </tr>

                        <tr>
                          <th>Mobile Number</th>
                          <td>{{ $admin_detail->mobile_number }}</td>
                          <th>Other Mobile</th>
                          <td>{{ $admin_detail->other_phone }}</td>
                          <th>Website</th>
                          <td>{{ $admin_detail->website }}</td>

                        </tr>

                        <tr>
                          <th>Mailing St:</th>
                          <td>{{ $admin_detail->mailing_st }}</td>
                          <th>Mailing City</th>
                          <td>{{ $admin_detail->mailing_city }}</td>
                          <th>Mailing State</th>
                          <td>{{ $admin_detail->mailing_state }}</td>
                        </tr>

                        <tr>
                          <th>Mailing Zip Code</th>
                          <td>{{ $admin_detail->mailing_zip_code }}</td>
                        </tr>


                        <tr>
                          <th>Status</th>
                          <td>{{ $admin_detail->status }}</td>
                          <th>Created At</th>
                          <td>{{ $admin_detail->created_at }}</td>
                        </tr>

                        <tr>
                          <th>How many number of admin center create?</th>
                          <td>{{ $admin_detail->number_of_admin_centers }}</td>
                        </tr>
                        <tr>
                          <th>How many number of users allowed in an admin center?</th>
                          <td>{{ $admin_detail->allow_no_of_users_in_cc }}</td>
                        </tr>

                      </table>
                    </div>
                  </div>

                </div>

                  {{-- <div class="scroller" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd"> --}}
                     <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered table-hover">
                           <thead>
                              <tr>
                                <th style="display: none">Id</th>
                                <th>Admin center Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Code</th>
                                <th>No of users allowed</th>
                                <th>Created At</th>
                                @if(session('contact_center_admin.0.type') != 2)
                                <th>Action</th>
                                @endif
                            </tr>
                           </thead>
                           <tbody>
                              @php $i = 1; @endphp
                                    @foreach($admin_centers as $admin)
                                    <tr>
                                        <td style="display: none">{{$admin->id}}</td>
                                        <td >{{$admin->organization_name}}</td>
                                        <td >{{$admin->email}}</td>
                                        <td >{{$admin->phone_number}}</td>
                                        <td >{{$admin->code}}</td>
                                        <td >{{$admin->no_of_users}}</td>
                                        <td >{{$admin->created_at}}</td>

                                        @if(session('contact_center_admin.0.type') != 2)
                                        <td >
                                            <div class="btn-group">
                                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>

                                                <div class="dropdown-menu">

                                                  {{-- <a class="dropdown-item status_change_admin" onclick="change_status_admin('{{$admin->id}}','{{$admin->status}}',this)">@if($admin->status == 'enabled')<i class="fa fa-toggle-off"></i> Disable @else <i class="fa fa-toggle-on"></i> Enable @endif</a> --}}

                                                  <a class="dropdown-item" href="{{ route('command-center-contact-center-detail',['org_id'=>$admin->organization_id, 'admin_id' => $admin_detail->id]) }}"><i class="fa fa-expand"></i> View Detail</a>

                                                  <a class="dropdown-item" href="{{ route('command-center-sub-admins',['org_id'=>$admin->organization_id, 'admin_id' => $admin_detail->id]) }}"><i class="fa fa-link"></i> Sub Admins</a>

                                                  <a class="dropdown-item" href="{{ route('command-center-users',['org_id'=>$admin->organization_id, 'admin_id' => $admin_detail->id]) }}"><i class="fa fa-link"></i> Users</a>

                                                  <a class="dropdown-item" href="{{ route('command-center-monitors',['org_id'=>$admin->organization_id, 'admin_id' => $admin_detail->id]) }}"><i class="fa fa-link"></i> Monitors</a>
                                                </div>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                                @php $i++; @endphp
                            </tbody>
                        </table>
                     </div>
                     {{-- {{ $admin_centers }} --}}
                  {{-- </div> --}}
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<div class="modal fade" id="edit_sub_contact_center" tabindex="-1" role="dialog" style="margin-top: -70px;">
   <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Edit Administrator</h4>
         </div>
         <!--Body-->
         <form class="form-group" id="edit-sub-contact-center"  novalidate="novalidate">
            <div class="modal-body">
               <div class="row">
                  <div id="form-column" class="col-md-12 col-sm-12">
                     <label class="form-label">Name</label>
                     <input class="form-control btn-circle" autocomplete="off" type="text" name="name" id="name" placeholder="Name">
                     <br>
                     <label class="form-label">Email</label>
                     <input class="form-control btn-circle" autocomplete="off" type="text" name="email" id="email" placeholder="Email" disabled>
                     <input class="form-control" type="hidden" name="id" id="id" placeholder="Email">
                     <br>
                     <div class="row edit-adminstrator">
                        <div class="col-sm-5">
                           <div class="form-group">
                              <label>Select Country code</label>
                              <select class="selectpicker form-control" disabled data-size='auto' data-style='btn-circle-left btn-xs'  data-live-search="true" name="phone_code">
                              <?php $countries = \App\Countries::all();?>
                              @foreach($countries as $country)
                              <option value="{{ $country->id }}" @if($country->id ==  session('contact_center_admin.0.country_id')) selected @endif>{{ $country->name }} (+{{ $country->phone_code }})</option>
                              @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="col-sm-7" id="col-six">
                           <label class="form-label">Phone</label>
                           <input class="form-control form-control-lg btn-circle-right" autocomplete="off" type="text" name="phone" id="phone" placeholder="Enter Numbers Only-No Spaces">
                        </div>
                     </div>
                     <br>
                     <label class="form-label">Address</label>
                     <input autocomplete="off" class="form-control btn-circle" type="text" name="address" id="address" placeholder="Address">
                     <br>
                     {{-- <label for="input_starttime">Start Time</label>
                     <input placeholder="Start Time" name="start_time" type="text" id="input_starttime" class="form-control timepicker">
                     <br/>
                     <label for="input_starttime1">End Time</label>
                     <input placeholder="End Time" name="end_time" type="text" id="input_starttime1" class="form-control timepicker"> --}}
                     <br/>
                     <div class="form-group">
                        <label>Additional Note</label>
                        <textarea name="additional_detail" id="additional_detail" placeholder="Additional Note" class="form-control btn-circle"></textarea>
                     </div>
                     <div  class="form-group additional_field">
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" id="add_additional" class="btn btn-primary btn-lg waves-effect">Add Additional Field</button>
               <button class="btn btn-warning btn-outline btn-lg"  id="edit_sub_contact_center_button">Save Administrator</button>
            </div>
         </form>
      </div>
      <!--/.Content-->
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="schedule-modal" tabindex="-1" role="dialog" aria-labelledby="schedule-modalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title text-md-center" id="schedule-modal-Label">Admin Schedule</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-sm-12">
                  <table  style="width: 100%" class="table table-bordered table-sm">
                     <thead id="schedule-thead">
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>Close Time</th>
                     </thead>
                     <tbody id="schedule-tbody">
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="edit_admin_schedule" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title"  id="edit_admin_scheduleLabel">Edit Schedule</h4>
         </div>
         <!--Body-->
         <form id="edit-admin-schedule">
            <input type="hidden" name="admin_id" id="admin_id">
            <div class="modal-body">
               <div class="row">
                  <div id="col-schedule" class="col-md-12 col-sm-12">
                    <br>
                    @php
                        $days = \App\Days::all();
                    @endphp
                     <div id="days-data">
                    @php
                        $hours = \App\Hours::orderBy('hour', 'asc')->get();
                        $schedules = \App\Schedule::where('admin_id', session('contact_center_admin.0.id'))->get();
                    @endphp
                        {{-- {{ dd($days) }} --}}
                        @foreach($days as $day)
                        <div class="row">
                           <div class="col-sm-4">
                              <label ><strong style="float:left;font-size: 17px!important;">{{ $day->name }}:</strong></label>
                           </div>
                           <div class="col-sm-3 pull-right">
                              <select class="form-control btn-circle" onchange="change_edit_schedule_status2('{{ strtolower($day->name) }}',this)" data-style="red" name="{{ strtolower($day->name) }}_status">
                              <option value="active" @foreach($schedules as $schedule) @if($schedule['status'] == 'active' && $schedule['day_id'] == $day['id']) selected @endif @endforeach>Active</option>
                              <option value="inactive" @foreach($schedules as $schedule) @if($schedule['status'] == 'inactive' && $schedule['day_id'] == $day['id']) selected @endif @endforeach>Inactive</option>
                              </select>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-3">
                              <select class="form-control btn-circle" @foreach($schedules as $schedule)@if($schedule['status'] == 'inactive' && $schedule['day_id'] == $day['id']) disabled @endif @endforeach data-style="red" name="{{ strtolower($day->name) }}_start_time">
                              <option value="" @foreach($schedules as $schedule)@if($schedule['open_time'] == '' && $schedule['day_id'] == $day['id']) selected @endif @endforeach> Set start time</option>
                              @foreach($hours as $hour)
                              <option value="{{ $hour->id }}" @foreach($schedules as $schedule) @if($schedule['open_time'] == $hour->id && $schedule['day_id'] == $day['id']) selected @endif @endforeach>{{ $hour->hour }}</option>
                              @endforeach
                              </select>
                           </div>
                           <div class="col-sm-3">
                              <select class="form-control btn-circle" @foreach($schedules as $schedule)@if($schedule['status'] == 'inactive' && $schedule['day_id'] == $day['id']) disabled @endif @endforeach data-style="red" name="{{ strtolower($day->name) }}_start_time_am_pm">
                              <option value="am" @foreach($schedules as $schedule)@if($schedule['open_time_format'] == "am" && $schedule['day_id'] == $day['id']) selected @endif @endforeach> AM</option>
                              <option value="pm" @foreach($schedules as $schedule) @if($schedule['open_time_format'] == "pm" && $schedule['day_id'] == $day['id']) selected @endif @endforeach> PM</option>
                              </select>
                              <br/>
                           </div>
                           <div class="col-sm-3">
                              <select class="form-control btn-circle" @foreach($schedules as $schedule)@if($schedule['status'] == 'inactive' && $schedule['day_id'] == $day['id']) disabled @endif @endforeach data-style="red" name="{{ strtolower($day->name) }}_close_time">
                              <option value="" @foreach($schedules as $schedule) @if($schedule['close_time'] == '' && $schedule['day_id'] == $day['id']) selected @endif @endforeach> Set Close time</option>
                              @foreach($hours as $hour)
                              <option value="{{ $hour->id }}" @foreach($schedules as $schedule) @if($schedule['close_time'] == $hour->id && $schedule['day_id'] == $day['id']) selected @endif @endforeach>{{ $hour->hour }}</option>
                              @endforeach
                              </select>
                           </div>
                           <div class="col-sm-3">
                              <select class="form-control btn-circle" @foreach($schedules as $schedule)@if($schedule['status'] == 'inactive' && $schedule['day_id'] == $day['id']) disabled @endif @endforeach data-style="red" name="{{ strtolower($day->name) }}_close_time_am_pm">
                              <option value="am" @foreach($schedules as $schedule) @if($schedule['close_time_format'] == "am" && $schedule['day_id'] == $day['id']) selected @endif @endforeach> AM</option>
                              <option value="pm" @foreach($schedules as $schedule) @if($schedule['close_time_format'] == "pm" && $schedule['day_id'] == $day['id']) selected @endif @endforeach> PM</option>
                              </select>
                           </div>
                        </div>
                        <hr>
                        @endforeach
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button class="btn btn-lg btn-warning" style="float: right;"  id="edit-admin-schedule-button">Update Schedule</button>
            </div>
         </form>
      </div>
   </div>
   <!--/.Content-->
</div>
<div class="modal fade" id="notes" tabindex="-1" role="dialog">
   <div class="modal-dialog " role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Notes</h4>
         </div>
         <!--Body-->
            <form class="form-group" id="sub-admin-note" novalidate="novalidate">
               <div class="modal-body">
                     <label class="form-label">Notes <span class="form-asterick">&#42;</span></label>
                     <textarea class="form-control" id="note" name="notes" placeholder="Notes" style="min-height: 100px"></textarea>
                     <input type="hidden" name="note_id" id="note_id">
                     <br>
               </div>
               <div class="modal-footer">
                     <button class="btn btn-lg btn-primary  waves-effect" id="noteButton">Save Changes</button>

               </div>
            </form>
         <!--/.Content-->
      </div>
   </div>
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

    function add_notes(note_id,note) {
            $('#note_id').val(note_id);
            $('#note').val(note);
            $('#notes').modal('show');
        }

        $('#admin-note').validate({
            errorClass : "error_color",
            rules: { message: { minlength: 5,maxlength:140,required: true },csv:{required:true}
            },

            submitHandler:function(form){
                $('#noteButton').attr('disabled',true);
                $('#noteButton').html('Loading ...');
                var formData = new FormData($("#admin-note")[0]);
                $.ajax({
                    url:"<?php echo url('/') ?>/contact_center/ajax/admin_note",
                    type:'post',
                    cache: "false",
                    contentType: false,
                    processData: false,
                    data: formData,
                    error:function(){
                        url='<?php echo url('/') ?>';
                    },
                    success:function(data)
                    {
                        $('#noteButton').attr('disabled',false);
                        $('#noteButton').html('Save Changes');
                        toastr["success"]('Saved Successfully');
                        window.setTimeout(function() { location.reload() }, 100)
                    }
                })


            }
        });

         //delete Admin
        $(document).on('click','.delete_admin',function(){
             current = $(this);
                id = $(this).data('id')
               bootbox.confirm("You are going to delete Admin Are you sure?", function (result) {

                if (result == true) {

            $.ajax({
                type : "POST",
                url : "{{url('ajax/delete_admin_for_master_control_center') }}",
                data : 'id='+id,
                success: function(data,status){
                    toastr['success']('admin deleted successfully')
             table = $('#example_1').DataTable();
                        table.row($(current).parents('tr')).remove().draw()
                      window.location.reload();
        }
            })

                }
            })
        })


        function change_status_admin(id,status,current)
        {

            bootbox.confirm("Are you sure you want to change the user status?", function (result) {
                if (result == true) {
                      $.ajax({
                    "method" : "GET",
                    url : "{{url('/ajax/change_admin_status_for_master_control_center')}}",
                    data : "id="+id+"&status="+status,
                    success : function(response,stat){

                        toastr["success"]('Changes confirmed');
                        if(response.status == 'enabled')
                        {
                            status_data = "Disable";
                            $(current).html('<i class="fa fa-toggle-off"></i>'+' '+status_data)
                        }else
                        {
                            status_data = "Enable"

                            $(current).html('<i class="fa fa-toggle-on"></i>'+' '+status_data)
                        }
                         window.setTimeout(function() { $('.toast-close-button').click(); }, 1000)
                    },
                });



                }
                else {

                }
            });
        }

        function showNote(current)
        {

        $(current).popover('toggle')

        }


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