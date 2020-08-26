<!DOCTYPE html>
<html lang="en">
<?php date_default_timezone_set('asia/jakarta'); ?>
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

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../assets/css/demo.css" rel="stylesheet" />
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
    <script src="<?= base_url(); ?>/assets/js/bootstrap.min.js"></script>
</head>

<body class="sidebar-mini">

<div class="wrapper">
<?= $this->include('layouts/sidebar'); ?>
        <div class="main-panel">
            <!-- Navbar -->
            <!-- <nav class="navbar navbar-expand-lg <?= ($submenu=='Parts') ? 'navbar-fixed' : '';?>"> -->
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-minimize">
                            <button id="minimizeSidebar" class="btn btn-info btn-fill btn-round btn-icon d-none d-lg-block">
                                <i class="fa fa-ellipsis-v visible-on-sidebar-regular"></i>
                                <i class="fa fa-navicon visible-on-sidebar-mini"></i>
                            </button>
                        </div>
                        <a class="navbar-brand" href="#pablo"> <?= $menu; ?> </a>
                    </div>
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end">
                        <!-- <ul class="nav navbar-nav mr-auto">
                            <form class="navbar-form navbar-search-form" role="search">
                                <div class="input-group">
                                    <input type="text" value="" class="form-control" placeholder="Search...">
                                    <i class="nc-icon nc-zoom-split"></i>
                                </div>
                            </form>
                        </ul> -->
                        <?php
                                $db = \Config\Database::connect();
                                $builder = $db->table('cart');
                                         $builder->where(['user_id' => session()->get('id')]); 
                                         $builder->orderBy('updated_at', 'DESC');
                                $query = $builder->limit(5)->get(); 
                                $total = $builder->where(['user_id' => session()->get('id')])->countAllResults(); 
                                ($total>5) ? $more = $total - 5 : $more = 0;

                                $fbuilder = $db->table('parts_favorite');
                                         $fbuilder->where(['user_id' => session()->get('id')]); 
                                         $fbuilder->orderBy('updated_at', 'DESC');
                                $fquery = $fbuilder->limit(5)->get(); 
                                $ftotal = $fbuilder->where(['user_id' => session()->get('id')])->countAllResults(); 
                                ($ftotal>5) ? $fmore = $ftotal - 5 : $fmore = 0;
                        ?>
                        <ul class="navbar-nav">
                            <?php if (session()->get('roleId')=='991'){ ?>
                            <li class="dropdown nav-item">
                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <i class="nc-icon nc-cart-simple"></i>
                                    <span class="notification"><?= $total; ?></span>
                                    <span class="d-lg-none">Items</span>
                                    <span class="stats">Troli</span>
                                </a>
                                    <ul class="dropdown-menu dropdown-menu-right" style="min-width: 22rem;">
                                <?php if ($total!=0){ ?>
                                    <?php
                                    $builder = $db->table('parts');
                                    foreach ($query->getResult() as $row) 
                                    {
                                    $part = $builder->where(['id' => $row->id])->get()->getRow();
                                    // if (empty($part)){
                                    //     $order_qty = 0;
                                    //     $price = 0;
                                    //     $photo = 'soldout.jpg';
                                    // }else{
                                    //     $order_qty = $row->order_qty;
                                    //     $price = $part->price;
                                    //     $photo = $part->photo;
                                    // }
                                    ?>
                                        <a class="dropdown-item" href="<?= base_url(); ?>/parts/item/<?= $row->id; ?>">
                                            <div class="card mt-0 mb-0" style="max-width: 350px;">
                                                <div class="row no-gutters">
                                                    <div class="col-md-2">
                                                        <img src="<?= base_url(); ?>/assets/img/parts/<?= (empty($part)) ? 'soldout.jpg' : $part->photo; ?>" style="width: 75px;" class="card-img mt-1" />
                                                    </div>
                                                    <div class="col-md-7 ml-3">
                                                        <div class="card-body">
                                                            <h5 class="card-title" style="font-size:75%;"><?= substr($row->description,0,32); ?></h5>
                                                            <h5 class="card-title" style="font-size:75%;"><?= substr($row->description,32,64); ?></h5>
                                                            <h5 class="card-title" style="font-size:75%;"><?= substr($row->description,64,98); ?></h5>
                                                            <?php if (empty($part)){ ?>
                                                                <div class="card-text"><small class="text-danger"> SOLD OUT </small></div>
                                                            <?php }else{ ?>
                                                                <?php if ($part->price==0){ ?>
                                                                    <div class="card-text"><small class="text-muted"><?= $row->order_qty.' '.$row->uom; ?></small> x <small class="badge badge-primary"> Hubungi Sales</small></div>
                                                                <?php }else{ ?>
                                                                    <div class="card-text"><small class="text-muted"><?= $row->order_qty.' '.$row->uom; ?></small> x <small class="text-success"> RP <?= number_format($part->price, 0, '.', ','); ?></small></div>
                                                                <?php } ?>
                                                            <?php } ?>
                                                            <div class="card-text"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php } ?>
                                        <li class="divider"></li>
                                            <a class="dropdown-item bg-primary text-center text-light" href="<?= base_url('/cart'); ?>"><?= ($total>5) ? '+'.$more.' Part | ' : '';?>Checkout</a>
                                <!-- </ul> -->
                                <?php }else{ ?>
                                    <!-- <ul class="dropdown-menu dropdown-menu-right" style="min-width: 25rem;"> -->
                                        <a class="dropdown-item" href="#">
                                            <div class="card mt-1 mb-1" style="max-width: 540px;">
                                                <div class="row no-gutters">
                                                    <div class="col-md-4 mt-1">
                                                    <img src="<?= base_url(); ?>/assets/img/cart.png" class="card-img" />
                                                    </div>
                                                    <div class="col-md-8 mt-4">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Oops!</h5>
                                                            <p class="card-text">Troli kamu masih kosong.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                <?php } ?>
                                </ul>
                            </li>
                            <li class="dropdown nav-item">
                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <i class="nc-icon nc-favourite-28"></i>
                                    <span class="notification"><?= $ftotal; ?></span>
                                    <span class="d-lg-none">Items</span>
                                    <span class="stats">Favorit</span>
                                </a>
                                    <ul class="dropdown-menu dropdown-menu-right" style="min-width: 22rem;">
                                <?php if ($ftotal!=0){ ?>
                                    <?php
                                    $builder = $db->table('parts');
                                    foreach ($fquery->getResult() as $row) 
                                    {
                                    $part = $builder->where(['id' => $row->id])->get()->getRow();
                                    ?>
                                        <a class="dropdown-item" href="<?= base_url(); ?>/parts/item/<?= $row->id; ?>">
                                            <div class="card mt-0 mb-0" style="max-width: 350px;">
                                                <div class="row no-gutters">
                                                    <div class="col-md-2">
                                                        <img src="<?= base_url(); ?>/assets/img/parts/<?= (empty($part)) ? 'soldout.jpg' : $part->photo; ?>" style="width: 75px;" class="card-img mt-1" />
                                                    </div>
                                                    <div class="col-md-7 ml-3">
                                                        <div class="card-body">
                                                            <h5 class="card-title" style="font-size:75%;"><?= substr($row->description,0,32); ?></h5>
                                                            <h5 class="card-title" style="font-size:75%;"><?= substr($row->description,32,64); ?></h5>
                                                            <h5 class="card-title" style="font-size:75%;"><?= substr($row->description,64,98); ?></h5>
                                                            <?php if (empty($part)){ ?>
                                                                <div class="card-text"><small class="text-danger"> SOLD OUT </small></div>
                                                            <?php }else{ ?>
                                                                <?php if ($part->price==0){ ?>
                                                                    <div class="card-text"><small class="badge badge-primary mt-2"> Hubungi Sales</small></div>
                                                                <?php }else{ ?>
                                                                    <div class="card-text"><small class="text-muted">RP <?=number_format($part->price, 0, '.', ',').' / '.$row->uom; ?></small></div>
                                                                    <?php } ?>
                                                            <?php } ?>
                                                            <div class="card-text"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php } ?>
                                        <li class="divider"></li>
                                            <a class="dropdown-item bg-primary text-center text-light" href="<?= base_url('/parts/favorite'); ?>"><?= ($ftotal>5) ? '+'.$fmore.' Part | ' : '';?>Selengkapnya</a>
                                <!-- </ul> -->
                                <?php }else{ ?>
                                    <!-- <ul class="dropdown-menu dropdown-menu-right" style="min-width: 25rem;"> -->
                                        <a class="dropdown-item" href="#">
                                            <div class="card mt-1 mb-1" style="max-width: 540px;">
                                                <div class="row no-gutters">
                                                    <div class="col-md-4 mt-1">
                                                    <img src="<?= base_url(); ?>/assets/img/broken-heart.png" class="card-img" />
                                                    </div>
                                                    <div class="col-md-8 mt-4">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Oops!</h5>
                                                            <p class="card-text">Tidak ada part favorit.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="nc-icon nc-bullet-list-67"></i>
                                    <span class="stats">Pengaturan</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="<?= base_url('users/profile'); ?>">
                                        <i class="nc-icon nc-email-85"></i> Profil
                                    </a>
                                    <!-- <a class="dropdown-item" href="#">
                                        <i class="nc-icon nc-umbrella-13"></i> Perusahaan
                                    </a> -->
                                    <a class="dropdown-item" href="#">
                                        <i class="nc-icon nc-settings-90"></i> Settings
                                    </a>
                                    <div class="divider"></div>
                                    <!-- <a class="dropdown-item" href="#">
                                        <i class="nc-icon nc-lock-circle-open"></i> Lock Screen
                                    </a> -->
                                    <a href="<?= base_url('auth/logout'); ?>" class="dropdown-item text-danger">
                                        <i class="nc-icon nc-button-power"></i> Log out
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <!-- <ul class="navbar-nav flex-row mt-5">
                        <form method="#" action="#">
                            <div class="input-group input-group-lg mt-2 mb-4">
                                <input type="text" class="form-control" id="mySearch" placeholder="Cari Komponen..." autofocus>
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            </div>
                        </form>
                        </ul> -->
                    </div>
                </div> 
            </nav>
            <!-- End Navbar -->
            <div class="flash-data" data-flashdata="<?= session()->getFlashdata('message'); ?>"></div>          
  
<?= $this->renderSection('content'); ?>
                                    
                                    <footer class="footer">
                                        <div class="container">
                                            <nav>
                                                <ul class="footer-menu">
                                                    <li>
                                                        <a href="#">
                                                            FAQs
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            Syarat dan Ketentuan
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            Pusat Bantuan
                                                        </a>
                                                    </li>
                                                </ul>
                                                <p class="copyright text-center">
                                                    ©
                                                    <script>
                                                        document.write(new Date().getFullYear())
                                                    </script>
                                                    <a href="https://www.winteq-astra.co.id">Winteq Digitalization Team</a>, made with <i class="nc-icon nc-favourite-28"></i> for a better future.
                                                </p>
                                            </nav>
                                        </div>
                                    </footer>
                                </div>
                            </div>
                            <div class="fixed-plugin">
                                <div class="dropdown show-dropdown">
                                    <a href="#" data-toggle="dropdown">
                                        <i class="fa fa-whatsapp fa-2x"> </i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header-title"> Sidebar Style</li>
                                        <li class="adjustments-line">
                                            <a href="javascript:void(0)" class="switch-trigger">
                                                <p>Background Image</p>
                                                <label class="switch-image">
                                                    <input type="checkbox" data-toggle="switch" checked="" data-on-color="info" data-off-color="info"><span class="toggle"></span>
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
                                                    <span class="badge filter badge-azure active" data-color="azure"></span>
                                                    <span class="badge filter badge-green" data-color="green"></span>
                                                    <span class="badge filter badge-orange" data-color="orange"></span>
                                                    <span class="badge filter badge-red" data-color="red"></span>
                                                    <span class="badge filter badge-purple" data-color="purple"></span>
                                                </div>
                                                <div class="clearfix"></div>
                                            </a>
                                        </li>
                                        <li class="header-title">Sidebar Images</li>

                                        <li class="active">
                                            <a class="img-holder switch-trigger" href="javascript:void(0)">
                                                <img src="../assets/img/sidebar-1.jpg" alt="" />
                                            </a>
                                        </li>
                                        <li>
                                            <a class="img-holder switch-trigger" href="javascript:void(0)">
                                                <img src="../assets/img/sidebar-3.jpg" alt="" />
                                            </a>
                                        </li>
                                        <li>
                                            <a class="img-holder switch-trigger" href="javascript:void(0)">
                                                <img src="../assets/img/sidebar-4.jpg" alt="" />
                                            </a>
                                        </li>
                                        <li>
                                            <a class="img-holder switch-trigger" href="javascript:void(0)">
                                                <img src="../assets/img/sidebar-5.jpg" alt="" />
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
                            </div>
                       
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
<!-- <script src="<?= base_url(); ?>/assets/js/sweetalert2.js" type="text/javascript"></script> -->
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
<!--  Notifications & Sweet Alert Plugin    -->
<script src="<?= base_url(); ?>/assets/js/notify-sweetalert2.js" type="text/javascript"></script>
    <!-- Light Dashboard DEMO methods, don't include it in your project! -->
<script src="../assets/js/demo.js"></script>
<script type="text/javascript">
    function setFormValidation(id) {
        $(id).validate({
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                $(element).closest('.form-check').removeClass('has-success').addClass('has-error');
            },
            success: function(element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                $(element).closest('.form-check').removeClass('has-error').addClass('has-success');
            },
            errorPlacement: function(error, element) {
                $(element).closest('.form-group').append(error).addClass('has-error');
            },
        });
    }

    $('.datepicker').datetimepicker({
        format: 'DD-MM-YYYY',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
        }
    });
    
    $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

        // demo.showNotification();

        demo.initVectorMap();
    });
</script>

<?php $this->renderSection('javascript'); ?>

</html>