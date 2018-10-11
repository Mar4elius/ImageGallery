<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Image Gallery</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-flatly.css">

    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

   <!-- <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/redmond/jquery-ui.css" rel="stylesheet">--> <!--REMOVE LATER-->

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo base_url(); ?>js/jquery-2.1.3.js"></script>
    <script src="<?php echo base_url(); ?>js/bootbox.js"></script>
    <!--masonry script-->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js"></script>
    <script src="<?php echo base_url(); ?>js/masonryScript.js"></script>
    <!--tinymce script-->
    <script src="<?php echo base_url(); ?>js/tinymce_4.7.11/tinymce/tinymce.min.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery-ui-1.10.0.custom.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            // fade message if exists
            if ($("#message").length) {
                $("#message").delay(3000).fadeOut({}, 3000);
            }
        }); // \ doc ready

        $(document).ready(function () {
            // fade message if exists
            if ($("#warning").length) {
                $("#warning").delay(3000).fadeOut({}, 3000);
            }
        }); // \ doc ready

        $(document).ready(function () {
            // fade message if exists
            if ($("#info").length) {
                $("#info").delay(3000).fadeOut({}, 3000);
            }
        }); // \ doc ready

        tinymce.init({
            selector: '#mytextarea'
        });

        $(document).ready(function() {
            $('#myCarousel').carousel({
                interval: 10000
            })
        });
    </script>

</head>


<body class="metro">

<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand active" href="<?php echo base_url(); ?>">Image Gallery</a>
            </div>


            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class=""><a href="<?php echo base_url(); ?>imageCMS/do_upload">Upload Your Image</a></li>
                </ul>
                <!-- ddl for login -->
                <?php if (!$this->tank_auth->is_logged_in()): ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo base_url() ?>auth/login">Login</a></li>

                        <li><a href="<?php echo base_url() ?>auth/register">Register</a></li>
                    </ul>
                <?php else:
                    $user_id = $this->tank_auth->get_user_id();
                    $username = $this->tank_auth->get_username();
                    ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li style="color:white;"><a><?php echo "Welcome, $username" ?></a></li>
                        <li><a href="<?php echo base_url() ?>auth/logout">Logout</a></li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle pull-right" data-toggle="dropdown" role="button"
                               aria-expanded="false">Settings<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo base_url() ?>imageCMS/manage_images">Manage My Images</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url() ?>auth/change_password">Change password</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url() ?>auth/change_email">Change Email</a></li>
                            </ul>
                        </li>
                    </ul>

                <?php endif; ?>


            </div><!--/.nav-collapse -->
        </div>
    </nav>
    <?php
    $messsage = $this->session->flashdata('message'); // assumes that you have loaded the session library;
    $warning = $this->session->flashdata('warning'); // assumes that you have loaded the session library;
    $info = $this->session->flashdata('info'); // assumes that you have loaded the session library;
    if ($messsage) {
        echo "\n<h3 class=\"alert alert-info\" id=\"message\"><i class=\" fa fa-check\"></i> $messsage</h3>";
    }
    if ($warning) {
        echo "\n<h3 class=\"alert alert-danger\" id=\"warning\"><i class=\" fa fa-times\"></i> $warning</h3>";
    }
    if ($info) {
        echo "\n<h3 class=\"alert alert-warning\" id=\"warning\"><i class=\" fa fa-exclamation-circle\"></i> $info</h3>";
    }
    ?>
