<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="utf-8"/>
        <title>Admin</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <link href="<?php echo Yii::app()->baseUrl ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo Yii::app()->baseUrl ?>/css/style-metronic.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo Yii::app()->baseUrl ?>/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo Yii::app()->baseUrl ?>/css/style-responsive.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo Yii::app()->baseUrl ?>/css/default.css" rel="stylesheet" type="text/css" id="style_color"/>
        <script src="<?php echo Yii::app()->baseUrl ?>/js/app.js" type="text/javascript"></script>
        <script>
            jQuery(document).ready(function () {
                App.init();
            });
        </script>
    </head>
    <body class="page-header-fixed">
        <div class="header navbar navbar-fixed-top">
            <div class="header-inner">
                <a class="navbar-brand" href="">
                    <!--<img src="" style="width:84px; height:14px;" alt="logo" class="img-responsive"/>-->
                </a>
                <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <img src="<?php echo Yii::app()->baseUrl ?>/image/menu-toggler.png" alt=""/>
                </a>
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" src="<?php echo Yii::app()->baseUrl ?>/image/avatar1_small.jpg" style="max-width:35px;max-height:27px;"/>&nbsp;
                            <?php
                            $user = User::model()->findByPk(Yii::app()->user->id);
                            ?>
                            <span class="username">
                                <?php echo $user->nama; ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
<!--                            <li>
                                <a href="<?php echo Yii::app()->baseUrl ?>">
                                    <i class="fa fa-user"></i> Edit Profile                                
                                </a>                            
                            </li>-->
                            <li>
                                <a href="<?php echo Yii::app()->createUrl('site/logout') ?>">
                                    <i class="fa fa-arrow-right"></i> logout                               
                                </a>                            
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clearfix">
        </div>
        <div class="page-container">
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">
                    <?php include "sidebar.php"; ?>
                </div>
            </div>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="panel panel-primary">
                        <div class="panel-heading"><?php echo $this->pageTitle ?></div>
                        <div class="panel-body">
                            <?php echo $content ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <div class="footer-inner">
                    2016 &copy; All Right Reserved
                </div>
                <div class="footer-tools">
                    <span class="go-top">
                        <i class="fa fa-angle-up"></i>
                    </span>
                </div>
            </div>
        </div>

    </body>
</html>