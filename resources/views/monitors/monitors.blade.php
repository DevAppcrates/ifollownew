@extends('layout.default')
@section('title')
    {{ config('app.name') }} | Monitors
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
                <div class="page-bar">
                </div>


                 <div class="row" style="margin-top: 3%">
                    <div class="col-md-12">
                        <div class="portlet light bg-inverse">
                            <div class="portlet-title">
                                <div class="caption font-green-sharp">
                                    <i class="icon-speech font-green-sharp"></i>
                                    <span class="caption-subject"> Monitors </span>
                                </div>

                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only red fullscreen" href="javascript:;"><i class="icon-size-fullscreen"></i> </a>
                                </div>

                            </div>

                            <div class="portlet-body">
                            <table class="table table-striped table-hover table-header-fixed responsive table-success" id="example2">
                                @php $i = 1; @endphp
                                <thead>
                                <tr>
                                    <th style="display: none">#</th>
                                    <th>Monitor Name</th>
                                    <th>Monitor Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Additional Detail</th>
                                    <th>Additional Fields</th>
                                    <th>Notes</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th style="display: none">#</th>
                                    <th>Monitor Name</th>
                                    <th>Monitor Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Additional Detail</th>
                                    <th>Additional Fields</th>
                                    <th>Notes</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    @php $i =1;  @endphp
                                @foreach($monitors as $monitor)
                                    <tr>
                                        <td style="display: none">{{$i}}</td>
                                        <td >{{$monitor->monitor_name}}</td>
                                        <td >{{$monitor->monitor_email}}</td>
                                        <td >{{$monitor->phone_number}}</td>
                                        <td >{{$monitor->address}}</td>
                                        <td >{{$monitor->additional_detail??'N/A'}}</td>
                                        <td >
                                                @if(is_array($monitor->additional_fields))
                                            <ol>
                                            @foreach($monitor->additional_fields as $field)
                                                <li>{{ $field }}</li>
                                            @endforeach
                                            </ol>
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td><a tabindex="0" role="button" data-trigger="focus" onclick="showNote(this)" class="btn btn-circle-bottom btn-primary btn-xs" data-toggle="popover"  data-placement="top" title="{{ $monitor->monitor_name }} Note" data-content="{{ $monitor->notes?$monitor->notes:"N/A" }}">View Notes</button>
                                        </td>
                                        <td >
                                            <div class="btn-group">
                                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>

                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item status_change_admin" title="Mass Notification Status" onclick="change_mns_status('{{$monitor->monitor_id}}','{{$monitor->mns_status}}',this)">@if($monitor->mns_status == 1)<i class="fa fa-toggle-on"></i> MNS Disable @else <i class="fa fa-toggle-off"></i>MNS Enable @endif</a>

                                                    <a class="dropdown-item" onclick="deleteMonitor(this,'{{ $monitor->id }}')" href="javascript:void(0)"><i class="fa fa-trash"></i> Delete</a>
                                                     <a class="dropdown-item" onclick="editMonitor(this)" data-monitor="{{ $monitor }}" href="javascript:void(0)"><i class="fa fa-edit"></i> Edit</a>
                                                    @php
                                                        $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($monitor->notes))))));

                                                    @endphp
                                                    <a class="dropdown-item" onclick="add_notes('{{$monitor->id}}','{{$clear}}')"><i class="fa fa-pencil"></i> Add/Edit Note</a>

                                                    <a class="dropdown-item" onclick="assign_monitor('{{$monitor->monitor_id}}')"><i class="fa fa-plus-circle"></i> Assign Monitor</a>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        </div>
                    </div>
                </div>
                <!-- END CONTENT -->
            </div>
        </div>

        {{-- Add Notes --}}
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
                    <div class="modal-body">
                        <form class="form-group" id="monitor-note" novalidate="novalidate">
                            <label class="form-label">Notes <span class="form-asterick">&#42;</span></label>
                            <textarea class="form-control" id="note" name="notes" placeholder="Notes" style="min-height: 100px"></textarea>
                            <input type="hidden" name="note_id" id="note_id">
                            <br>
                            <button class="btn" id="noteButton" style="margin: auto;width: 100%;padding-left: 40px; padding-right: 40px; color: #222;margin-left: 2px;background-color: #0275d8;">Save Changes</button>
                        </form>
                    </div>
                    <!--/.Content-->
                </div>
            </div>
        </div>

        {{-- Assign Monitors --}}
        <div class="modal fade" id="assign_monitors" tabindex="-1" role="dialog">
            <div class="modal-dialog " role="document">
                <!--Content-->
                <div class="modal-content" style="margin-top: 70px">
                    <!--Header-->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Assign Monitors To Admin Center</h4>
                    </div>
                    <!--Body-->
                    <div class="modal-body">
                        <div id="error-msg" style="display: none;">Please select at least 1 admin center!</div>
                        <form class="form-group" id="assign-monitor-to-admin" novalidate="novalidate">
                            <input type="hidden" name="monitor id" id="monitor_id">
                            <div class="form-group" style="margin-bottom: 20px">
                                 <label class="form-label">Admin Centers</label>
                                 <select class="selectpicker form-control" data-size='auto' data-style='btn' multiple data-live-search="true" name="contact_centers[]">
                                    @php

                                        $contactCenters = \App\Organizations::where('admin_id', session('admin.0.id'))->where('type', 1)->get();
                                    @endphp
                                    @foreach($contactCenters as $contactCenter)
                                     <option value="{{ $contactCenter->organization_id }}">{{ $contactCenter->organization_name }}</option>
                                    @endforeach
                                 </select>
                            </div>
                            <br>
                            <button class="btn" id="assignButton" style="margin: auto; width: 100%;padding-left: 40px; padding-right: 40px; color: #222;margin-left: 2px;background-color: #0275d8;">Assign</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Edit Monitor -->
        <div class="modal fade" id="edit_monitor_command_center" tabindex="-1" role="dialog">
           <div class="modal-dialog" role="document">
              <!--Content-->
              <div class="modal-content" style="margin-top: 70px">
                 <!--Header-->
                 <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Update Monitor</h4>
                 </div>
                 <!--Body-->
                <form class="form-group" id="edit-monitor-command-center"  novalidate="novalidate">
                    <div class="modal-body">
                       <input type="hidden" name="id">
                       <label class="form-label">Monitor Name</label>
                       <input class="form-control btn-circle" type="text" name="user_name" autocomplete="off" placeholder="Name">
                       <br>
                       <label class="form-label">Monitor Email</label>
                       <input class="form-control btn-circle" type="text" autocomplete="off" name="email" placeholder="Monitor Email">
                       <br>
                       <div class="row">
                          <div class="col-sm-5">
                             <div class="form-group">
                                <label>Select Country code</label>
                                <select class="selectpicker form-control" data-size='auto' data-style='btn-circle-left btn-xs'  data-live-search="true" name="phone_code">
                                <?php $countries = \App\Countries::all();?>
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }} (+{{ $country->phone_code }})</option>
                                @endforeach
                                </select>
                             </div>
                          </div>
                          <div class="col-sm-7" id="col-six">
                             <label class="form-label">Monitor Phone</label>
                             <input class="form-control btn-circle-right form-control-lg" autocomplete="off" style="height: 29px;" type="text" name="phone" placeholder="Enter Numbers Only-No Spaces">
                          </div>
                       </div>
                       <br>
                       <label class="form-label">Address</label>
                       <input class="form-control btn-circle" autocomplete="off" type="text" name="address" placeholder="Address">

                       <br>
                       <div class="form-group">
                          <label>Additional Note</label>
                          <textarea name="additional_detail" placeholder="Additional Note" class="form-control btn-circle"></textarea>
                       </div>
                       <div class="additional_field"></div>
                    </div>
                    <div class="modal-footer">
                       <button type="button" id="add_additional" class="btn btn-primary btn-lg waves-effect">Add Additional Field</button>
                       <button class="btn btn-lg btn-warning"  id="edit_monitor_button">Update Monitor</button>
                    </div>
                 </form>
              </div>
              <!--/.Content-->
           </div>
        </div>

<style>

    #assign_monitors #error-msg{
        margin-bottom: 10px;
        display: block;
        background-color: red;
        color: white;
        text-align: center;
        padding: 10px;
    }


    #spantags > span.badge.badge-pill.light-blue {
        margin-top: 3px !important;
        width: 100px !important;
        height: 13px !important;
    }

    ul.pagination li {
        display: inline;
        font-size: 12px;
        font-weight: bold;
    }

    ul.pagination li a {

        color: black;
        padding: 10px 15px;
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
</style>

@stop

@section('scripts')

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{url('public')}}/assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="{{url('public')}}/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="{{url('public')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{url('public')}}/assets/pages/scripts/table-datatables-responsive.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
<script>
    $.fn.dataTable.ext.errMode = 'none';

    $(document).ready(function() {
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
    });

    function editMonitor(obj){
        var monitor = $(obj).data('monitor');
        $('#edit_monitor_command_center input[name="id"]').val(monitor.id);
        $('#edit_monitor_command_center input[name="user_name"]').val(monitor.monitor_name);
        $('#edit_monitor_command_center input[name="email"]').val(monitor.monitor_email);
        $('#edit_monitor_command_center input[name="address"]').val(monitor.address);
        $('#edit_monitor_command_center input[name="phone"]').val(monitor.phone_number.substring(3));
        $('#edit_monitor_command_center select[name="phone_code"]').val(monitor.phone_code.id).selectpicker('refresh');
        $('#edit_monitor_command_center textarea[name="additional_detail"]').val(monitor.additional_detail);
        var selectedCcs = monitor.organizations.map((o)=>{ return o.organization_id});
        $('#edit_monitor_command_center select[name="contact_centers[]"]').selectpicker('val',selectedCcs);
        if(monitor.additional_fields != null)
                {
                    $('#edit-contact-center .additional_field').empty();
                    $.each(monitor.additional_fields,function(k,v){

                            $('#edit-monitor .additional_field').append('<div id="additional_field" class="form-group"><label class="form-label">Additional Field</label><input type="text" class="form-control" value="'+v+'" placeholder="Add Some Additional" name="additional_fields[]"></div>');
                    })
                }else{
                    $('#edit-monitor .additional_field').empty();
                }
        $('#edit_monitor_command_center').modal('show');
    }

    function  view_detail_readonly(id,u_name,name,email,phone,code,address,no_of_users) {
        $('#contact_center_detail_2 #id').val(id);
        $('#contact_center_detail_2 #name').val(name);
        $('#contact_center_detail_2 #user_name').val(u_name);
        $('#contact_center_detail_2 #email').val(email);
        $('#contact_center_detail_2 #phone').val(phone);
        $('#contact_center_detail_2 #code').val(code);
        $('#contact_center_detail_2 #address').val(address);
        $('#contact_center_detail_2 #no_of_users').val(no_of_users);
        $('#contact_center_detail_2').modal('show')
    }

    function add_notes(note_id,note) {
        $('#note_id').val(note_id);
        $('#note').val(note);
        $('#notes').modal('show');
    }

    $('#monitor-note').validate({
        rules: { message: { minlength: 5,maxlength:140,required: true },csv:{required:true}
        },

        submitHandler:function(form){
            $('#noteButton').attr('disabled',true);
            $('#noteButton').html('Loading ...');
            var formData = new FormData($("#monitor-note")[0]);
            $.ajax({
                url:"<?php echo url('/') ?>/ajax/monitor_note",
                type:'post',
                cache: "false",
                contentType: false,
                processData: false,
                data: formData,
                error:function(){
                    url='<?php echo url('/') ?>/monitor-hub';
                },
                success:function(data)
                {
                    $('#noteButton').attr('disabled',false);
                    $('#noteButton').html('Save Changes');
                    toastr["success"]('Saved successfully');
                    window.setTimeout(function() { location.reload() }, 500)
                }
            })


        }
    });

    function assign_monitor(id) {
        $('#assign_monitors #monitor_id').val(id);
        $('#assign_monitors').modal('show');
    }

    $('#assign-monitor-to-admin').validate({
        rules: {
            contact_centers:{required:true}
        },

        submitHandler:function(form){
            var admincenters = $('select[name="contact_centers[]"]').val();
            if(admincenters == null){
                $('#assign_monitors #error-msg').css("display", "block");
                setTimeout(function(){ $('#assign_monitors #error-msg').css("display", "none");; }, 5000);
                return false;
            }else{

                $('#assignButton').attr('disabled',true);
                $('#assignButton').html('Loading ...');
                var formData = new FormData($("#assign-monitor-to-admin")[0]);
                $.ajax({
                    url:"<?php echo url('/') ?>/ajax/assign_monitor",
                    type:'post',
                    cache: "false",
                    contentType: false,
                    processData: false,
                    data: formData,
                    error:function(){
                        url='<?php echo url('/') ?>/monitor-hub';
                    },
                    success:function(data)
                    {
                        $('#assignButton').html('Save Changes');
                        toastr["success"]('Saved successfully');
                        window.setTimeout(function() { location.reload() }, 500)
                    }
                })
            }

        }
    });

    function showNote(current)
    {
        $(current).popover('toggle')
    }

    function change_status(id)
    {
        bootbox.confirm("Are you sure you want to change the monitor status?", function (result) {
            if (result == true) {
                $.get("<?php echo url('/'); ?>/ajax/monitor_status/"+id, function (result) {

                    toastr["success"]('Changes confirmed');

                    window.setTimeout(function() { location.reload(); }, 1000)

                });
            }
            else {

            }
        });
    }

    function change_mns_status(id)
    {
        bootbox.confirm("Are you sure you want to change the Mass Notification Status?", function (result) {
            if (result == true) {
                $.get("<?php echo url('/'); ?>/ajax/monitor_mns_status/"+id, function (result) {

                    toastr["success"]('Changes confirmed');

                    window.setTimeout(function() { location.reload(); }, 1000)

                });
            }
            else {

            }
        });
    }

    function deleteMonitor(e, id)
    {
        bootbox.confirm("Are you sure you want to delete Selected monitor?", function (result) {
            if (result == true) {
                $.post("<?php echo url('/'); ?>/ajax/delete_monitor/"+id, function (result) {

                    toastr["success"]('Deleted successfully!');

                    window.setTimeout(function() { location.reload(); }, 1000)

                });
            }
            else {

            }
        });
    }

    //Edit Monitor
    $('#edit-monitor-command-center').validate({
        errorClass : 'text-danger',
        rules: {
            name: {required: true},start_time: {required: true},end_time: {required: true},
            email: {required: true,email:true},
            phone: {required: true,number:true,minlength:10,maxlength:11},

        },
        messages: {

            // password: {
            //     pwcheck: "Password at-least 6 characters long and a combination of number and letter",
            //     minlength : "Password at-least 6 characters long and a combination of number and letter",
            // }

        },
        submitHandler: function(form) {

            $('#edit_monitor_button').attr('disabled', true);
            $('#edit_monitor_button').html('Loading ...');
            var formData = new FormData($("#edit-monitor-command-center")[0]);
            $.ajax({
                url: "{{url('/')}}/ajax/edit_monitor",
                type: 'post',
                cache: "false",
                contentType: false,
                processData: false,
                data:formData,
                error: function(errors) {
                    $('#edit_monitor_button').attr('disabled', false);
                    $('#edit_monitor_button').html('Update Monitor');
                    error = $.parseJSON(errors.responseText);
                    $.each(error,function(key,value){
                        if(typeof value.monday_start_time != 'undefined')
                        {
                            toastr['error'](value.monday_start_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000);
                        }
                        if(typeof value.monday_close_time != 'undefined')
                        {
                            toastr['error'](value.monday_close_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000);
                        }
                        if(typeof value.tuesday_start_time != 'undefined')
                        {
                            toastr['error'](value.tuesday_start_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000);

                        }
                        if(typeof value.tuesday_close_time != 'undefined')
                        {
                            toastr['error'](value.tuesday_close_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000);

                        }

                        if(typeof value.wednesday_start_time != 'undefined')
                        {
                            toastr['error'](value.wednesday_start_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000);

                        }
                        if(typeof value.wednesday_close_time != 'undefined')
                        {
                            toastr['error'](value.wednesday_close_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000);

                        }

                        if(typeof value.thursday_start_time != 'undefined')
                        {
                            toastr['error'](value.thursday_start_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000);

                        }
                        if(typeof value.thursday_close_time != 'undefined')
                        {
                            toastr['error'](value.thursday_close_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000);

                        }
                        if(typeof value.friday_start_time != 'undefined')
                        {
                            toastr['error'](value.friday_start_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000);

                        }
                        if(typeof value.friday_close_time != 'undefined')
                        {
                            toastr['error'](value.friday_close_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000);

                        }

                        if(typeof value.saturday_start_time != 'undefined')
                        {
                            toastr['error'](value.saturday_start_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000);

                        }
                        if(typeof value.saturday_close_time != 'undefined')
                        {
                            toastr['error'](value.saturday_close_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000);

                        }

                        if(typeof value.sunday_start_time != 'undefined')
                        {
                            toastr['error'](value.sunday_start_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000);

                        }
                        if(typeof value.sunday_close_time != 'undefined')
                        {
                            toastr['error'](value.sunday_close_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000);

                        }
                    })


                },
                success: function(data) {
                    $('#edit_monitor_button').attr('disabled', false);
                    $('#edit_monitor_button').html('Update Monitor');
                    if (data == 'success') {
                        toastr["success"]('Updated successfully');
                        window.setTimeout(function() {
                            location.reload();
                        }, 500)
                    } else {
                        toastr["error"](data);
                    }
                }
            })
        }
    })

    $('#monitor-note').validate({
        errorClass : 'text-danger',
        rules: {


        },
        messages: {


        },
        submitHandler: function(form) {

            $('#noteButton').attr('disabled', true);
            $('#noteButton').html('Loading ...');
            var formData = new FormData($("#monitor-note")[0]);
            $.ajax({
                url: "{{url('/')}}/ajax/monitor-note",
                type: 'post',
                cache: "false",
                contentType: false,
                processData: false,
                data:formData,
                error: function(errors) {
                    $('#noteButton').attr('disabled', false);
                    $('#noteButton').html('Update Note');
                    error = $.parseJSON(errors.responseText);
                    $.each(error,function(key,value){

                    })

                },
                success: function(data) {
                    // $('#noteButton').attr('disabled', false);
                    $('#noteButton').html('Update Note');
                    if (data == 'success') {
                        toastr["success"]('Updated successfully');
                        window.setTimeout(function() {
                            location.reload();
                        }, 500)
                    } else {
                        toastr["error"](data);
                    }
                }
            })
        }
    })



</script>


@stop