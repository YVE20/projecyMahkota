<?php

include "Security.php";
include "Koneksi.php";
include "asset/function/function.php";
// $active = "active";
date_default_timezone_set("Asia/Jakarta");

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="keyword" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION['nama_perusahaan']; ?></title>

    <!-- start: Css -->
    <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">

    <!-- plugins -->
    <link rel="stylesheet" type="text/css" href="asset/plugins/fontawesome/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/simple-line-icons.css" />
    <link rel="stylesheet" type="text/css" href="node_modules/select2/dist/css/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/datatables.bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/fullcalendar.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/select.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/responsive.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/rowReorder.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="node_modules/chart.js/dist/Chart.min.css" />
    <link rel="stylesheet" type="text/css" href="node_modules/print-js/dist/print.css" />

    <link href="asset/css/style.css" rel="stylesheet" type="text/css">
    <link href="asset/css/addstyle.css" rel="stylesheet" type="text/css">
    <link href="asset/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="node_modules/alertifyjs/build/css/alertify.min.css" rel="stylesheet" type="text/css" />
    <link href="node_modules/alertifyjs/build/css/themes/semantic.min.css" rel="stylesheet" type="text/css" />
    <link href="asset/plugins/colorbox/colorbox.css" rel="stylesheet" type="text/css" />
    <link href="asset/plugins/open-iconic/font/css/open-iconic-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- end: Css -->

    <link rel="shortcut icon" href="asset/img/<?php echo $_SESSION['icon']; ?>">

    <style>
        .card-dash {
            background-image: url('asset/img/bg_dash.jpg');
            object-fit: contain;
            background-repeat: no-repeat;
            height: 200px;
            border-radius: 20px;
        }

        .nav-tabs.nav-tabs-v3 {
            padding-top: 0px;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        .card-img {
            filter: grayscale(70%);
            webkit-filter: grayscale(70%);
            width: 100%;
            height: 150px;
            border-radius: calc(.25rem - 1px);
            object-fit: cover;
        }

        .card-img-overlay {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            padding: 3rem;
        }

        .card-title {
            margin-bottom: .75rem;
        }

        .card-text {
            /* margin-top:-70px;
            margin-left:20px;
            margin-bottom: 10px; */
        }


        .align-middle {
            vertical-align: middle !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-wrap {
            white-space: normal !important;
        }

        .alertify-notifier .ajs-message.ajs-success {
            color: #ffffff;
            background: #2196F3;
            text-shadow: -1px -1px 0 rgba(0, 0, 0, 0, 5);
        }

        .btn-tablev2 {
            /* background-image:url('asset/img/table_img_alt.png'); */
            object-fit: cover;
            background-color: #fa8231;
            background-image: linear-gradient(to bottom right, #fa8231, #fd9644);
        }

        .btn-table {
            /* background-image:url('asset/img/table_img_alt.png'); */
            object-fit: cover;
            background-color: #2196F3;
            background-image: linear-gradient(to bottom right, #2196F3, #48c6f0);
        }

        .btn-table-dis {
            object-fit: cover;
            background-color: #babec2;
            background-image: linear-gradient(to bottom right, #babec2, #e1e2e3);
        }

        .table-review th,
        .table-review td {
            padding: 5px;
            text-align: left;
        }

        #left-menu .sub-left-menu .active {
            border-left: 4px solid #2196F3;
        }

        div.dataTables_wrapper {
            /* width: 800px; */
            margin: 0 auto;
        }

        
    </style>

    <script src="asset/js/jquery.min.js"></script>
</head>

<body id="mimin" class="dashboard">
    <!-- start: Header -->
    <nav class="navbar navbar-default header navbar-fixed-top">
        <div class="col-md-12 nav-wrapper">
            <div class="navbar-header" style="width:100%;">
                <div class="opener-left-menu <?php echo (($menu_head == "penjualan" ? 'is-closed'  : 'is-open')); ?> ">
                    <span class="top"></span>
                    <span class="middle"></span>
                    <span class="bottom"></span>
                </div>
                <a href="home.php" class="navbar-brand">
                    <b><?php echo $_SESSION['nama_perusahaan']; ?></b>
                </a>

                <ul class="nav navbar-nav navbar-right user-nav" style="padding-right:50px;">
                    <li class="user-name"><span><?php echo $_SESSION['nama']; ?></span></li>
                    <li class="dropdown avatar-dropdown">
                        <img src="asset/img/avatar2.png" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" />
                        <ul class="dropdown-menu user-dropdown">
                            <li><a href="Logout.php"><span class="fa fa-power-off" style="margin-right:10px;"></span>Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- end: Header -->

    <div class="container-fluid mimin-wrapper">

        <!-- start:Left Menu -->
        <div id="left-menu">
            <div class="sub-left-menu scroll">
                <ul class="nav nav-list">
                    <li>
                        <div class="left-bg"></div>
                    </li>
                    <li class="time">
                        <h1 class="animated fadeInLeft">21:00</h1>
                        <p class="animated fadeInRight">Sat,October 1st 2029</p>
                    </li>


                        <li class="<?php echo (($menu_head == "home" ? 'active'  : ''));  ?> ripple"><a href="home.php"><span class="fa fa-home"></span>Home</a></li>

                        <li class=" <?php echo (($menu_head == "penjualan" ? 'active'  : ''));  ?> ripple">
                            <a class="tree-toggle nav-header">
                                <span class="fa-money fa"></span> Penjualan
                                <span class="fa-angle-right fa right-arrow text-right"></span>
                            </a>
                            <ul class="nav nav-list tree">
                                <li><a href="frmpenjualan.php?act=new&id="><span class="fa fa-cart-plus"></span> Penjualan</a></li>
                                <?php
                                if ($_SESSION['status'] == "Admin" || $_SESSION['status'] == "Karyawan" || $_SESSION['status'] == "Owner") {
                                ?>
                                    <li><a href="frmlistpenjualan.php"><span class="fa fa-list"></span> List Penjualan</a></li>
                                <?php } ?>
                            </ul>
                        </li>


                        <?php
                        if ($_SESSION['status'] == "Admin" || $_SESSION['status'] == "Karyawan" || $_SESSION['status'] == "Owner") {
                        ?>
                            <li class=" <?php echo (($menu_head == "pembelian" ? 'active'  : ''));  ?> ripple">
                                <a class="tree-toggle nav-header">
                                    <span class="fa-sticky-note fa"></span> Pembelian
                                    <span class="fa-angle-right fa right-arrow text-right"></span>
                                </a>
                                <ul class="nav nav-list tree">
                                    <?php
                                    if ($_SESSION['status'] == "Karyawan" || $_SESSION['status'] == "Admin" || $_SESSION['status'] == "Owner") {
                                    ?>
                                        <li><a href="frmpembelian.php?act=po&id="><span class="fa fa-credit-card"></span>Input Pembelian</a></li>
                                    <?php
                                    } ?>

                                    <?php
                                    if ($_SESSION['status'] == "Admin"|| $_SESSION['status'] == "Owner") {
                                    ?>
                                        <li><a href="frmlistpembelian.php"><span class="fa fa-list"></span>Pembelian</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php
                        }
                        ?>


                        <?php
                        if ($_SESSION['status'] == "Supervisor") {
                        ?>
                            <li class=" <?php echo (($menu_head == "pembelian" ? 'active'  : ''));  ?> ripple">
                                <a class="tree-toggle nav-header">
                                    <span class="fa-sticky-note fa"></span> Pembelian
                                    <span class="fa-angle-right fa right-arrow text-right"></span>
                                </a>
                                <ul class="nav nav-list tree">
                                    <?php
                                    if ($_SESSION['status'] == "Karyawan" || $_SESSION['status'] == "Admin") {
                                    ?>
                                        <li><a href="frmpembelian.php?act=po&id="><span class="fa fa-credit-card"></span>Input Pembelian</a></li>
                                    <?php
                                    } ?>

                                    <?php
                                    if ($_SESSION['status'] == "Admin") {
                                    ?>
                                        <li><a href="frmlistpembelian.php"><span class="fa fa-list"></span>Pembelian</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php
                        }
                        ?>

                        <?php
                        if ($_SESSION['status'] == "Admin") {
                        ?>
                            <li class=" <?php echo (($menu_head == "laporan" ? 'active'  : ''));  ?> ripple">
                                <a class="tree-toggle nav-header">
                                    <span class="fa-area-chart fa"></span> Laporan
                                    <span class="fa-angle-right fa right-arrow text-right"></span>
                                </a>
                                <ul class="nav nav-list tree">
                                <li><a href="lappenjualan_detil.php">Penjualan</a></li>
                                    <!-- <li><a href="lappenjualan.php">Penjualan</a></li> -->
                                    <!-- <li><a href="lappenjualan_detil.php">Penjualan Detil</a></li> -->
                                    <!-- <li><a href="lappembelian.php">Pembelian</a></li> -->
                                    <li><a href="lappembelian_detil.php">Pembelian</a></li>
                                    <!-- <li><a href="lappembelian_detil.php">Pembelian Detil</a></li> -->
                                    <!-- <li><a href="lapprofit.php">Profit Penjualan</a></li> -->
                                </ul>
                            </li>
                            <li class="<?php echo (($menu_head == "data" ? 'active'  : ''));  ?> ripple"><a class="tree-toggle nav-header">
                                    <span class="fa fa-pencil-square"></span> Master Data <span class="fa-angle-right fa right-arrow text-right"></span> </a>
                                <ul class="nav nav-list tree">
                                    <li><a href="frmproduk.php">Produk</a></li>
                                    <li><a href="frmstokproduk.php">Stok Opname</a></li>
                                    <li><a href="frmsatuan.php">Satuan</a></li>
                                    <li><a href="frmsupplier.php">Supplier</a></li>
                                    <li><a href="frmuser.php">User</a></li>
                                    <li><a href="frmkonsumen.php">Konsumen</a></li>
                                    <li><a href="frmkategoribarang.php"> Kategori Barang </a></li>
                                </ul>
                            </li>
                            <li class="<?php echo (($menu_head == "sistem" ? 'active'  : ''));  ?> ripple"><a class="tree-toggle nav-header">
                                    <span class="fa fa-cogs"></span> Sistem <span class="fa-angle-right fa right-arrow text-right"></span> </a>
                                <ul class="nav nav-list tree">
                                    <li><a href="frmlicense.php"><span class="fa fa-gear"></span> Konfigurasi</a></li>
                                </ul>
                            </li>
                        <?php
                        }
                        ?>

<?php
                        if ($_SESSION['status'] == "Owner") {
                        ?>
                            <li class=" <?php echo (($menu_head == "laporan" ? 'active'  : ''));  ?> ripple">
                                <a class="tree-toggle nav-header">
                                    <span class="fa-area-chart fa"></span> Laporan
                                    <span class="fa-angle-right fa right-arrow text-right"></span>
                                </a>
                                <ul class="nav nav-list tree">
                                    <li><a href="lappenjualan_detil.php">Penjualan</a></li>
                                    <!-- <li><a href="lappenjualan.php">Penjualan</a></li> -->
                                    <!-- <li><a href="lappenjualan_detil.php">Penjualan Detil</a></li> -->
                                    <!-- <li><a href="lappembelian.php">Pembelian</a></li> -->
                                    <li><a href="lappembelian_detil.php">Pembelian</a></li>
                                    <!-- <li><a href="lappembelian_detil.php">Pembelian Detil</a></li> -->
                                    <!-- <li><a href="lapprofit.php">Profit Penjualan</a></li> -->
                                </ul>
                            </li>
                            <li class="<?php echo (($menu_head == "data" ? 'active'  : ''));  ?> ripple"><a class="tree-toggle nav-header">
                                    <span class="fa fa-pencil-square"></span> Master Data <span class="fa-angle-right fa right-arrow text-right"></span> </a>
                                <ul class="nav nav-list tree">
                                    <li><a href="frmproduk.php">Produk</a></li>
                                    <li><a href="frmstokproduk.php">Stok Opname</a></li>
                                    <li><a href="frmsatuan.php">Satuan</a></li>
                                    <li><a href="frmsupplier.php">Supplier</a></li>
                                    <li><a href="frmuser.php">User</a></li>
                                    <li><a href="frmkonsumen.php">Konsumen</a></li>
                                    <li><a href="frmkategoribarang.php"> Kategori Barang </a></li>
                                </ul>
                            </li>
                            <li class="<?php echo (($menu_head == "sistem" ? 'active'  : ''));  ?> ripple"><a class="tree-toggle nav-header">
                                    <span class="fa fa-cogs"></span> Sistem <span class="fa-angle-right fa right-arrow text-right"></span> </a>
                                <ul class="nav nav-list tree">
                                    <li><a href="frmlicense.php"><span class="fa fa-gear"></span> Konfigurasi</a></li>
                                </ul>
                            </li>
                        <?php
                        }
                        ?>

                </ul>
            </div>
        </div>
        <!-- end: Left Menu -->

    </div>
    <?php
    // include "Footer.php";
    ?>
    <script>

    </script>