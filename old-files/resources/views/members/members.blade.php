@extends('layout.default')
@section('title')
    {{ config('app.name') }} | Admin Centers
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

                        {{-- {{ dd($users) }} --}}
                         <div class="row" style="margin-top: 3%">
                            <div class="col-md-12">
                                <div class="portlet light bg-inverse">
                                    <div class="portlet-title">
                                        <div class="caption font-green-sharp">
                                            <i class="icon-speech font-green-sharp"></i>
                                            <span class="caption-subject"> Admin Centers </span>
                                        </div>

                                        <div class="actions">
                                            <a class="btn btn-circle btn-icon-only red fullscreen" href="javascript:;"><i class="icon-size-fullscreen"></i> </a>
                                        </div>

                                    </div>

                                        <div class="portlet-body">

                                            <div class="table-responsive">
                                                <table id="example2" class="table table-striped table-bordered table-hover">
                                                        @php $i = 1; @endphp
                                                            <thead>
                                                                @php $i = 1; @endphp
                                                                <th style="display: none">#</th>
                                                                <th>Name</th>
                                                                <th>Organization Name</th>
                                                                <th>Code</th>
                                                                <th>No of users</th>
                                                                <th>Notes</th>
                                                                <th>Action</th>

                                                            </thead>

                                                            <tbody>
                                                              @php $i =1;  @endphp
                                                                @foreach($users as $user)
                                                                    <tr>
                                                                        <td style="display: none">{{$i}}</td>
                                                                        <td >{{$user->name}}</td>
                                                                        <td >{{$user->organization_name}}</td>
                                                                        <td >{{$user->code}}</td>
                                                                        <td >{{$user->no_of_users}}</td>
                                                                              <td><a tabindex="0" role="button" data-trigger="focus" onclick="showNote(this)" class="btn btn-circle-bottom btn-primary btn-xs" data-toggle="popover"  data-placement="top" title="{{ $user->organization_name }} Note" data-content="{{ $user->notes?$user->notes:"N/A" }}">View Notes</button></td>
                                                                        <td >
                                                                            <div class="btn-group">
                                                                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>

                                                                                <div class="dropdown-menu">

                                                                                     <a class="dropdown-item" href="{{ route('contact-center-detail',['org_id'=>$user->organization_id]) }}"><i class="fa fa-expand"></i> View Detail</a>
                                                                                    @php
                                                                                        $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($user->notes))))));

                                                                                    @endphp
                                                                                    <a class="dropdown-item" onclick="add_notes('{{$user->id}}','{{$clear}}')"><i class="fa fa-pencil"></i> Add/Edit Note</a>

                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    @php $i++; @endphp
                                                                @endforeach
                                                            </tbody>

                                                </table>

                                            </div>
                    <!-- END CONTENT BODY -->
                                            {{-- </div> --}}
                                        </div>
                                </div>
                            </div>
                        </div>
                <!-- END CONTENT -->
            </div>
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
                    <div class="modal-body">
                        <form class="form-group" id="sub-admin-note" novalidate="novalidate">
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

<style>


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

            $('#sub-admin-note').validate({
                rules: {
                    message: { minlength: 5,maxlength:140,required: true },csv:{required:true}
                },

                submitHandler:function(form){
                    $('#noteButton').attr('disabled',true);
                    $('#noteButton').html('Loading ...');
                    var formData = new FormData($("#sub-admin-note")[0]);
                    $.ajax({
                        url:"<?php echo url('/') ?>/contact_center/ajax/organization_note",
                        type:'post',
                        cache: "false",
                        contentType: false,
                        processData: false,
                        data: formData,
                        error:function(){
                            url='<?php echo url('/') ?>/contact_center/';
                        },
                        success:function(data)
                        {
                            $('#noteButton').attr('disabled',false);
                            $('#noteButton').html('Save Changes');
                            toastr["success"]('Saved successfully');
                            window.setTimeout(function() { location.reload() }, 100)
                        }
                    })


                }
            });

            function showNote(current){
                $(current).popover('toggle');
            }

        </script>


@stop