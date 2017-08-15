<?php
if (empty($this->session->userdata("user_id"))) {
    redirect(site_url(), 'refresh');
}
$system_date = $this->session->userdata('System_date');
?>
<!DOCTYPE html>
<html>
    <head>
        <title id="title"></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">        
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker-bs3.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/iCheck/all.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/colorpicker/bootstrap-colorpicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datepicker/datepicker3.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/timepicker/bootstrap-timepicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js2/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js2/dataTables.tableTools.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/js2/dataTables.tableTools.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css">

        <!-- AdminLTE Skins. Choose a skin from the css/skins
                 folder instead of downloading all of them to reduce the load. -->




        <style>
            #ajax_load {  
                position:fixed;
                width:100%;
                height:100%;
                z-index:1000;
                background-color:#808080;
                opacity: .6;
            }

            .ajax-loader {
                position: absolute;
                left: 50%;
                top: 50%;
                margin-left: -32px; /* -1 * image width / 2 */
                margin-top: -32px;  /* -1 * image height / 2 */
                display: block;     
            }
        </style>
    </head>
</head>

<body class="hold-transition skin-purple fixed sidebar-mini">
    <div id="ajax_load" style="display:none;">
        <img src="<?php echo base_url(); ?>plugins/gif-load.gif" class="ajax-loader"/>
    </div>
    <div class="wrapper">

        <header class="main-header"><a href="#" class="logo">
                <span class="logo-mini"><b>IRIS</b></span><span class="logo-lg"> <b>IRIS Admin</b>
                </span> </a>
            <nav class="navbar navbar-static-top" role="navigation"><a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
                                <img src="<?php echo base_url(); ?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> 
                                <span class="hidden-xs"><?php echo $this->session->userdata('emp_name'); ?></span> </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="<?php echo base_url(); ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                    <p> <?php echo $this->session->userdata('emp_name'); ?></p>
                                </li>

                                <li class="user-footer">
                                    <div class="pull-left"> <a href="#" class="btn btn-default btn-flat">Profile</a> </div>
                                    <div class="pull-right"> <a href="<?php echo base_url(); ?>login/user_login" class="btn btn-default btn-flat">Sign out</a> </div>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>
