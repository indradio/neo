<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url(); ?>/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="<?= base_url(); ?>/assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>NEO - WINTEQ PARTS CENTER</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="<?= base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url(); ?>/assets/css/light-bootstrap-dashboard.css?v=2.0.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../../assets/css/demo.css" rel="stylesheet" />
</head>

<body>
    <div class="wrapper wrapper-full-page">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute">
            <div class="container">
                <div class="navbar-wrapper">
                    <a class="navbar-brand" href="#pablo">NEO - Winteq Patrs Center</a>
                    <!-- <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button> -->
                </div>
                <div class="collapse navbar-collapse justify-content-end" id="navbar">
                    <ul class="navbar-nav">
                        <!-- <li class="nav-item">
                            <a href="../dashboard.html" class="nav-link">
                                <i class="nc-icon nc-chart-pie-35"></i> Dashboard
                            </a>
                        </li> -->
                        <li class="nav-item ">
                            <a href="<?= base_url('auth/register'); ?>" class="nav-link">
                                <i class="nc-icon nc-badge"></i> Register
                            </a>
                        </li>
                        <li class="nav-item  active ">
                            <a href="#" class="nav-link">
                                <i class="nc-icon nc-mobile"></i> Login
                            </a>
                        </li>
                        <!-- <li class="nav-item ">
                            <a href="lock.html" class="nav-link">
                                <i class="nc-icon nc-key-25"></i> Lock
                            </a>
                        </li> -->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="full-page  section-image" data-color="azure" data-image="<?= base_url(); ?>/assets/img/full-screen-image-2.jpg" ;>
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="content">
                <div class="container">
                    <div class="col-md-5 col-sm-6 ml-auto mr-auto">
                        <form class="form" method="post" action="<?= base_url('auth/submit'); ?>">
                            <div class="card card-login card-hidden">
                                <div class="card-header">
                                    <div class="row justify-content-center">
                                        <div class="col-md-11">
                                            <div class="header-text">
                                                <h2 class="card-title">Login</h2>
                                                <h4 class="card-subtitle">Winteq Parts Center</h4>
                                                <hr />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body ">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" placeholder="Enter Email" id="email" name="email" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" placeholder="Password" id="pswd" name="pswd" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <a href="<?= base_url(); ?>">
                                            <!-- <label> -->
                                                    <small>Belum punya akun? Daftar</small>
                                                <!-- </label> -->
                                                </a>
                                            <!-- <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" value="" checked>
                                                    <span class="form-check-sign"></span>
                                                    Subscribe to newsletter
                                                </label>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer mr-auto ml-auto">
                                    <button type="submit" class="btn btn-wd btn-success btn-outline">
                                        Login
                                        <span class="btn-label btn-label-right">
                                            <i class="fa fa-arrow-right"></i>
                                        </span>
                                    </button>
                                    </br>
                                    <a href="<?= base_url(); ?>" class="btn btn-wd btn-link">
                                        <small>Reset Password</small>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <nav>
                    <!-- <ul class="footer-menu">
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Company
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Portfolio
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Blog
                            </a>
                        </li>
                    </ul> -->
                    <p class="copyright text-center float-center">
                        ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="https://www.winteq-astra.com">Winteq Digitalization Team</a>, made with <i class="nc-icon nc-favourite-28"></i> for a better future.
                    </p>
                </nav>
            </div>
        </footer>
    </div>
    <!-- <div class="fixed-plugin">
        <div class="dropdown show-dropdown">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-cog fa-2x"> </i>
            </a>
            <ul class="dropdown-menu">
                <li class="header-title"> Sidebar Style</li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger">
                        <p>Background Image</p>
                        <label class="switch-image">
                            <input type="checkbox" data-toggle="switch" checked="" data-on-color="info" data-off-color="info">
                            <span class="toggle"></span>
                        </label>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger">
                        <p>Sidebar Mini</p>
                        <label class="switch-mini">
                            <input type="checkbox" data-toggle="switch" data-on-color="info" data-off-color="info">
                            <span class="toggle"></span>
                        </label>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger">
                        <p>Fixed Navbar</p>
                        <label class="switch-nav">
                            <input type="checkbox" data-toggle="switch" data-on-color="info" data-off-color="info">
                            <span class="toggle"></span>
                        </label>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger background-color">
                        <p>Filters</p>
                        <div class="pull-right">
                            <span class="badge filter badge-black" data-color="black"></span>
                            <span class="badge filter badge-azure" data-color="azure"></span>
                            <span class="badge filter badge-green" data-color="green"></span>
                            <span class="badge filter badge-orange active" data-color="orange"></span>
                            <span class="badge filter badge-red" data-color="red"></span>
                            <span class="badge filter badge-purple" data-color="purple"></span>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="header-title">Sidebar Images</li>
                <li class="active">
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="../../assets/img/sidebar-1.jpg" alt="" />
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="../../assets/img/sidebar-3.jpg" alt="" />
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="../../assets/img/sidebar-4.jpg" alt="" />
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="../../assets/img/sidebar-5.jpg" alt="" />
                    </a>
                </li>
                <li class="button-container">
                    <div>
                        <a href="http://www.creative-tim.com/product/light-bootstrap-dashboard" target="_blank" class="btn btn-info btn-block">Get free demo!</a>
                    </div>
                </li>
                <li class="button-container">
                    <div>
                        <a href="http://www.creative-tim.com/product/light-bootstrap-dashboard-pro" target="_blank" class="btn btn-warning btn-block btn-fill">Buy now!</a>
                    </div>
                </li>
                <li class="button-container">
                    <div>
                        <a href="http://www.creative-tim.com/product/light-bootstrap-dashboard-pro/documentation/tutorial-components.html" target="_blank" class="btn btn-danger btn-block">Documentation</a>
                    </div>
                </li>
                <li class="header-title" id="sharrreTitle">Thank you for sharing!</li>
                <li class="button-container">
                    <button id="twitter" class="btn btn-social btn-twitter btn-round sharrre"><i class="fa fa-twitter"></i> · 256</button>
                    <button id="facebook" class="btn btn-social btn-facebook btn-round sharrre"><i class="fa fa-facebook-square"> · 426</i></button>
                </li>
            </ul>
        </div>
    </div> -->
</body>
<!--   Core JS Files   -->
<script src="<?= base_url(); ?>/assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>/assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="<?= base_url(); ?>/assets/js/plugins/bootstrap-switch.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?YOUR_KEY_HERE"></script>
<!--  Chartist Plugin  -->
<script src="<?= base_url(); ?>/assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="<?= base_url(); ?>/assets/js/plugins/bootstrap-notify.js"></script>
<!--  jVector Map  -->
<script src="<?= base_url(); ?>/assets/js/plugins/jquery-jvectormap.js" type="text/javascript"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?= base_url(); ?>/assets/js/plugins/moment.min.js"></script>
<!--  DatetimePicker   -->
<script src="<?= base_url(); ?>/assets/js/plugins/bootstrap-datetimepicker.js"></script>
<!--  Sweet Alert  -->
<script src="<?= base_url(); ?>/assets/js/plugins/sweetalert2.min.js" type="text/javascript"></script>
<!--  Tags Input  -->
<script src="<?= base_url(); ?>/assets/js/plugins/bootstrap-tagsinput.js" type="text/javascript"></script>
<!--  Sliders  -->
<script src="<?= base_url(); ?>/assets/js/plugins/nouislider.js" type="text/javascript"></script>
<!--  Bootstrap Select  -->
<script src="<?= base_url(); ?>/assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>
<!--  jQueryValidate  -->
<script src="<?= base_url(); ?>/assets/js/plugins/jquery.validate.min.js" type="text/javascript"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="<?= base_url(); ?>/assets/js/plugins/jquery.bootstrap-wizard.js"></script>
<!--  Bootstrap Table Plugin -->
<script src="<?= base_url(); ?>/assets/js/plugins/bootstrap-table.js"></script>
<!--  DataTable Plugin -->
<script src="<?= base_url(); ?>/assets/js/plugins/jquery.dataTables.min.js"></script>
<!--  Full Calendar   -->
<script src="<?= base_url(); ?>/assets/js/plugins/fullcalendar.min.js"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="<?= base_url(); ?>/assets/js/light-bootstrap-dashboard.js?v=2.0.1" type="text/javascript"></script>
<!-- Light Dashboard DEMO methods, don't include it in your project! -->
<script src="../../assets/js/demo.js"></script>
<script>
    $(document).ready(function() {
        demo.checkFullPageBackgroundImage();

        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>

</html>