<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Master Hub Forgot Password</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{ url('/public') }}/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/public') }}/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/public') }}/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/public') }}/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{ url('/public') }}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/public') }}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ url('/public') }}/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ url('/public') }}/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{ url('/public') }}/assets/pages/css/login-2.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/public') }}/scripts/css/toastr.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" />



         </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="javascript:void(0)">
                <img src="{{url('/public')}}/images/logo@3x.png" style="height: 70px;" alt=""/>
            </a>
        </div>
			<div class="row">
            <div class="col-md-6 text-center">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <h3><i class="fa fa-exclamation-triangle"></i> &nbsp;<small class="text-white">{{ session('error') }}</small></h3>

                    </div>
                  @endif
                  @if(session('success'))

                    <div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <h3>
                            <i class="fa fa-check"></i> &nbsp;
                            <small class="text-white">{{ session('success') }}</small>
                        </h3>
                    </div>
                @endif

                @php
                    if (Session::has('admin')) {
            	@endphp
                    <script type="text/javascript">
                        url='{{ url('/') }}master-hub/dashboard';
                        window.setTimeout(function() { window.location.href = url }, 500)
                    </script>
                @php
                    }
                @endphp

            </div>
    		</div>


        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
             <form class="" action="" id="master_hub_forget_form" method="post">
                <div class="form-title">
                    <span class="form-title">Forget Password ?</span><br/>
                    <span class="form-subtitle" style="margin-left: -10px">Enter your e-mail to verify yourself!</span>
                </div>
                <div class="form-group">
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
                <div class="form-actions">
                    <a type="button" id="back-btn" class="btn btn-default" href="{{ url('/master-hub') }}">Back To Login</a>
                    <button type="submit" class="btn btn-primary uppercase pull-right" id="forgetMasterHubButton">Verify</button>
                </div>
            </form>

        </div>

<script type="text/javascript" src="<?php echo url('/') ?>/public/js/material.js"></script>

        <!-- jquery validation -->
        <script type="text/javascript" src="{{url('/')}}/public/js/jquery.min.js"></script>

        <script src="{{ url('/public') }}/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="{{ url('/public') }}/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="{{ url('/public') }}/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="{{ url('/public') }}/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ url('/public') }}/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="{{ url('/public') }}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ url('/public') }}/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ url('/public') }}/assets/pages/scripts/login.min.js" type="text/javascript"></script>


        <script type="text/javascript" src="{{url('/')}}/public/js/bootbox.js"></script>


        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
    <script>
        $(document).ready(function()
        {
            $('#clickmewow').click(function()
            {
                $('#radio1003').attr('checked', 'checked');
            });
        })

         //Master Hub Forget
        $('#master_hub_forget_form').validate({
            errorClass : 'text-danger',
            rules: { password: { minlength: 6,required: true }, email: {required: true}
            },

            submitHandler:function(form){

                $('#forgetMasterHubButton').attr('disabled',true);
                $('#forgetMasterHubButton').html('Loading ...');
                $.ajax({
                    url:"{{ url('/') }}/ajax/forget",
                    type:'post',
                    data: $("#master_hub_forget_form").serialize(),
                    error:function(){
                        url='{{ url('/master-hub') }}';
                    },
                    success:function(data)
                    {
                         url='{{ url('/master-hub') }}';
                        $('#forgetMasterHubButton').attr('disabled',false);
                        $('#forgetMasterHubButton').html('Verify');
                        if(data.response =='success')
                        {
                            var dialog = bootbox.dialog({
                            message: '<p class="text-center"><h3>password Verification Link has been sent to your email address kindly. check it out & change the password safely... </h3></p>',
                            closeButton: false
                            });


                            window.setTimeout(function() { dialog.modal('hide'); }, 5000)
                            window.setTimeout(function() { window.location.href = url }, 6000)
                        }
                        else
                        {
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-center",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                            toastr["error"](data);
                        }
                    }
                })
            }
        });


        </script>
    </body>

</html>