@extends('layout.default')
@section('title')
{{ config('app.name') }} | Command Centers
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
                     <span class="caption-subject"> Command Centers</span>
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
                                <th>Account Name</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date Created</th>
                                @if(session('contact_center_admin.0.type') != 2)
                                <th>Action</th>
                                @endif
                            </tr>
                           </thead>
                           <tbody>
                              @php $i = 1;
                              @endphp
                                    @foreach($admins as $admin)
                                    <tr>
                                        <td style="display: none">{{$admin->id}}</td>
                                        <td >{{$admin->business_name}}</td>
                                        <td >{{$admin->name}} {{$admin->last_name}}</td>
                                        <td >{{$admin->email}}</td>
                                        <td >{{$admin->created_at}}</td>

                                        @if(session('contact_center_admin.0.type') != 2)
                                        <td >
                                            <div class="btn-group">
                                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>

                                                <div class="dropdown-menu">
                                                  <a class="dropdown-item" href="{{ route('command-center-detail',['admin_id'=>$admin->id]) }}"><i class="fa fa-link"></i> Detail</a>

                                                  <a class="dropdown-item" href="javascript:void(0)" onclick="edit_user('{{ $admin }}')">
                                                    <i class="fa fa-link"></i>
                                                    Update
                                                  </a>

                                                  <a class="dropdown-item status_change_admin" onclick="change_status_admin('{{$admin->id}}','{{$admin->status}}',this)">@if($admin->status == 'enabled')<i class="fa fa-toggle-off"></i> Disable @else <i class="fa fa-toggle-on"></i> Enable @endif</a>

                                                  <a class="dropdown-item delete_admin" data-id='{{$admin->id}}'><i class="fa fa-trash"></i> Delete</a>

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
                  {{-- </div> --}}
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->

<!--Edit command center by command center-->
<div class="modal fade" id="edit_command_center" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Update Profile</h4>
         </div>
         <!--Body-->
         <div class="modal-body">
            <form class="form-group" id="edit-command-center"  novalidate="novalidate">

               <input hidden type="text" name="admin_id" id="admin-id" value="">

               <label class="form-label">Business Name</label>
               <input id="business-name" class="form-control btn-circle" type="text" value="" name="business_name" placeholder="Business Name">
               <br>

               <label class="form-label">Business Type</label>
               <input id="business-type" class="form-control btn-circle" type="text" value="" name="business_type" placeholder="Business Type">
               <br>

               <label class="form-label">First Name</label>
               <input id="first-name" class="form-control btn-circle" type="text" value="" name="first_name" placeholder="First Name">
               <br>

               <label class="form-label">Last Name</label>
               <input id="last-name" class="form-control btn-circle" type="text" value="" name="last_name" placeholder="Last Name">
               <br>

               <label class="form-label">Title</label>
               <input id="title" class="form-control btn-circle" type="text" value="" name="title" placeholder="Title">
               <br>

               <label class="form-label">Email</label>
               <input id="email" class="form-control btn-circle" type="text" value="" disabled redonly placeholder="Email">
               <br>


               <label class="form-label">Phone Number</label>
               <input id="phone-number" class="form-control btn-circle" type="text" value="" name="phone_number" placeholder="Phone Number">
               <br>

               <label class="form-label">Other Phone Number</label>
               <input id="other-phone-number" class="form-control btn-circle" type="text" value="" name="other_phone_number" placeholder="Other Phone Number">
               <br>

               <label class="form-label">Website</label>
               <input id="website" class="form-control btn-circle" type="text" value="" name="website" placeholder="Website">
               <br>

               <label class="form-label">Mailing St:</label>
               <input id="mailing-st" class="form-control btn-circle" type="text" value="" name="mailing_st" placeholder="Mailing St:">
               <br>

               <label class="form-label">Mailing City</label>
               <input id="mailing-city" class="form-control btn-circle" type="text" value="" name="mailing_city" placeholder="Mailing City">
               <br>

               <label class="form-label">Mailing State</label>
               <input id="mailing-state" class="form-control btn-circle" type="text" value="" name="mailing_state" placeholder="Mailing State">
               <br>

               <label class="form-label">Mailing Zip Code</label>
               <input id="mailing-zip-code" class="form-control btn-circle" type="text" value="" name="mailing_zip_code" placeholder="Mailing Zip Code">
               <br>

               <label class="form-label">Number Of Admin Centers</label>
               <input id="number-of-admin-centers" class="form-control btn-circle" name="number of admin centers" type="text" value="" placeholder="Put Number Here">
               <br>
               <label class="form-label">Number Of Users Allowd</label>
               <input id="number-of-allowed-users" class="form-control btn-circle" name="number of allowed user" type="text" value="" placeholder="Put Number Here">

               <br>
               <button class="btn btn-block btn-warning"  id="edit_command_center_button"> Update Profile</button>
            </form>
         </div>
      </div>
      <!--/.Content-->
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


    function edit_user(obj) {
      var obj = JSON.parse(obj);
      $('#admin-id').val(obj.id);
      $('#business-name').val(obj.business_name);
      $('#business-type').val(obj.business_type);
      $('#first-name').val(obj.name);
      $('#last-name').val(obj.last_name);
      $('#title').val(obj.title);
      $('#email').val(obj.email);
      $('#phone-number').val(obj.mobile_number);
      $('#other-phone-number').val(obj.other_phone);
      $('#website').val(obj.website);
      $('#mailing-st').val(obj.mailing_st);
      $('#mailing-city').val(obj.mailing_city);
      $('#mailing-state').val(obj.mailing_state);
      $('#mailing-zip-code').val(obj.mailing_zip_code);
      $('#number-of-admin-centers').val(obj.number_of_admin_centers);
      $('#number-of-allowed-users').val(obj.allow_no_of_users_in_cc);
      $('#edit_command_center').modal('show');
    }

     // Edit Command center by Master Admin
      $('#edit-command-center').validate({
          rules: {
              first_name: {required: true},
              last_name: {required: true},
              business_name: {required: true},
              business_type: {required: true},
              title: {required: true},
          },

          messages: {
              // password: {
              //     pwcheck: "Password at-least 6 characters long and a combination of number and letter",
              //     minlength : "Password at-least 6 characters long and a combination of number and letter",
              //     number_of_admin_centers: 'Number Of Admin Centers must be numbers and required'
              // }
          },
          errorClass : 'text-danger',
          submitHandler: function(form) {

              $('#edit_command_center_button').attr('disabled', true);
              $('#edit_command_center_button').html('Loading ...');
              var formData = new FormData($("#edit-command-center")[0]);
              $.ajax({
                  url: "{{url('/')}}/ajax/update_command_center",
                  type: 'post',
                  cache: "false",
                  contentType: false,
                  processData: false,
                  data:formData,
                  error: function(errors) {
                      url = '{{ url('/') }}';
                  },
                  success: function(data) {
                      // $('#edit_command_center_button').attr('disabled', false);
                      $('#edit_command_center_button').html('Update Profile');

                          toastr["success"](data);
                          window.setTimeout(function() {
                              location.reload();
                          }, 500)
                  }
              })
          }
      });



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