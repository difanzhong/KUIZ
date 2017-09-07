<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,300,800,700' rel='stylesheet' type='text/css'> <!-- 'Open Sans' font family from google -->
    <link rel="stylesheet" href="<?php echo base_url('/assets/css/kuiz_style.css');?>" type="text/css" />
    <script type="text/javascript" src="<?php echo base_url('/assets/js/jquery-1.11.3.min.js'); ?>"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function(){
           $('#userset').click(function(){
               window.location.href = '<?php echo base_url("/User"); ?>';
           });
            $('.icon-logout').click(function(){
                window.location.href = 'http://api.uqcloud.net/logout';
            });
        });

    </script>
</head>
<body>
<div class="top-bar">
    <div class="top-bar-inner">
        <img height="62" width="124" class="logo" src="<?php echo base_url('/assets/Img/LOGO.png') ?>" style="float: left;"/>
        <div class="btns-right">
            <i class="icon icon-logout" title="Logout"></i> <!-- click function in <head> with Jquery script-->
            <i class="icon icon-setting" id="userset" title="Set user information"></i> <!-- click function in <head> with Jquery script-->
            <i class="icon icon-bell" title=""></i>
        </div>
        <div class="user-info">
            <span class="username"><?php echo isset($_SESSION['username'])?$_SESSION['username']:'' ?></span>
            <img height="42" width="42" class="logo"
                 src="<?php echo isset($_SESSION['avatar'])?base_url('/uploads/'.$_SESSION['avatar']):''; ?>"
                 style="border-radius: 100%;float:right;margin-top:10px;"/>
        </div>

        <!-- navigation buttons -->
        <!--
            <ul class="nav-bar">
                <li>
                    <a href="javascript:void(0);">Quiz</a>
                </li>
                <li>
                    <a href="javascript:void(0);">Discussion</a>
                </li>
                <li>
                    <a href="javascript:void(0);">Leaderboard</a>
                </li>
            </ul>
        -->
    </div>
</div>
