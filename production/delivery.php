<?php

    session_start();

    require_once '../function.php';

    date_default_timezone_set('Asia/Jakarta');

    /* let's just comment awalTanggal & akhirTanggal first */

    $awalTanggal = date('01-m-Y');

    $akhirTanggal = date('d-m-Y');

    $awalTanggalStatus = date('01-m-Y');

    $akhirTanggalStatus = date('d-m-Y');

    // cek apakah user sudah login, apabila belum login arahkan user ke laman login

    if(!isset($_SESSION['user_login'])) {
      header("location:../login.php");  
    }

    $user_segmen = $_SESSION['segmen_user'];

    // var_dump($user_segmen);

    $nama = $_SESSION['user_login'];

    $user_data = $_SESSION['user_server'];

    $sales = $_SESSION['sales_force'];

    $status_pengiriman = '';

    if(!isset($status_pengiriman)) $status_pengiriman = '';

    // filter noTransaksi
    if(isset($_REQUEST['filter_transaksi'])){
      $_SESSION['FilterChecklistDateFrom'] = $_POST['awalTanggal'];
		  $_SESSION['FilterChecklistDateTo'] = $_POST['akhirTanggal']; 
    }

    if(isset($_SESSION['FilterChecklistDateFrom'])) $awalTanggal = $_SESSION['FilterChecklistDateFrom'];
	  if(isset($_SESSION['FilterChecklistDateTo'])) $akhirTanggal = $_SESSION['FilterChecklistDateTo'];

    //filter tgl status
    if(isset($_POST['filter_tgl_status'])){
      $_SESSION['FilterStatusFrom'] = $_POST['awalStatus'];
      $_SESSION['FilterStatusTo'] = $_POST['akhirStatus'];
      $_SESSION['FilterStatus'] = $_POST['status_pengiriman'];
    }

    if(isset($_SESSION['FilterStatusFrom'])) $awalTanggalStatus = $_SESSION['FilterStatusFrom'];
	  if(isset($_SESSION['FilterStatusTo'])) $akhirTanggalStatus = $_SESSION['FilterStatusTo'];
    if(isset($_SESSION['FilterStatus'])) $status_pengiriman = $_SESSION['FilterStatus'];
    // var_dump($status_pengiriman);  

    $database = query("SELECT * FROM [WMS-System].[dbo].[TB_Server] WHERE aktif = 1");
    
?>

<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Tell the browser to be responsive to screen width -->

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="author" content="Vinson">

    <title>PT. Sardana IndahBerlian Motor</title>

    <!-- Favicon icon -->

    <link

      rel="icon"

      type="image/png"

      sizes="16x16"

      href="assets/images/sardana.png"
    />

    <!-- Custom CSS -->

    <link

      rel="stylesheet"

      type="text/css"

      href="assets/extra-libs/multicheck/multicheck.css"/>

    <link
    
      href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css"

      rel="stylesheet"/>

    <link href="css/style.min.css" rel="stylesheet" />

    <link href="css/styles.css" rel="stylesheet" />

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"> -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="css/datatables.css" rel="stylesheet"/>

    <!-- Loading CSS -->

    <link href="css/loading.css" rel="stylesheet"/>

    <!-- Bootstrap Datepicker CSS -->

    <link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"/>

    <!-- Google Font -->
    
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">

    <style>

      /* Disable box shadows for this table */

      /* table.dataTable.stripe > tbody > tr.odd > *, 
      table.dataTable.display > tbody > tr.odd > * {
        box-shadow: none;
      }

      table.dataTable.hover > tbody > tr:hover > *, table.dataTable.display > tbody > tr:hover > * {
        box-shadow: none;
      }

      table.dataTable.hover > tbody > tr.selected:hover > *, table.dataTable.display > tbody > tr.selected:hover > * {
        box-shadow: none;
      }

      table.dataTable.display tbody tr:hover > .sorting_1, table.dataTable.order-column.hover tbody tr:hover > .sorting_1 {
        box-shadow: none;
      }

      table.dataTable.display tbody tr:hover > .sorting_2, table.dataTable.order-column.hover tbody tr:hover > .sorting_2 {
        box-shadow: none;
      }

      table.dataTable.display tbody tr:hover > .sorting_3, table.dataTable.order-column.hover tbody tr:hover > .sorting_3 {
        box-shadow: none;
      }

      table.dataTable.display > tbody > tr.odd > .sorting_1, 
      table.dataTable.order-column.stripe > tbody > tr.odd > .sorting_1 {
        box-shadow: none;
      } */
    
      .bg-diterima { 
        background-color: #fcb1ac !important;
      }

      .bg-dikirim {
        background-color: #e8ff78 !important;
      }

      .bg-selesai {
        background-color: #7aff8c !important;
      }

      .bg-choose {
        background-color: #6eff94 !important;
      }

      body {
        overflow-x:auto;
      }
    
      table.dataTable.compact thead th,
      table.dataTable.compact thead td {
        padding: 4px 13px !important;
      }

      .nav-img {
        margin-right: 10px;
      }

      .pro-pic:hover{
        color: whitesmoke !important;
      }

      .profile-sidebar {
        opacity: 1 !important;
      }

      .sidebar-link img {
        width: 45px;
        margin-right: 15px;
      }

      .page-logo {
        font-family: 'Montserrat', sans-serif;
        font-size: 2.5rem;
        color: #ed0000;
      }

      .btn {
        color: #000;
      }

      .btn:hover {
        color: #fff;
      }

      /* adding required labels */
      
      .required::before {
        content: ' * ';
        color: red;
        margin-right: 3px;
      }

      div.loader {
        position: fixed;
        top: 0;
        left: 0;
        margin-top:1px;
        margin-left:1px;
        z-index: 99999;
        -moz-opacity: 0.50;
        opacity: 0.50;
        top: 50%;
        left: 50%;
      }

      div.dataTables_wrapper div.dataTables_processing {
        height: 100%;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        margin-top:1px;
        margin-left:1px;
        z-index: 99999;
        background-color: gray;
        -moz-opacity: 0.50;
        opacity: 0.50;
	    }

      div.dataTables_wrapper div.dataTables_processing .loader{
        position: absolute;
        top: 50%;
        left: 50%;
	    }



    </style>

  </head>

  
  <body>

    <div class='loader'></div>


    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >
      <!-- ============================================================== -->
      <!-- Topbar header - style you can find in pages.scss -->
      <!-- ============================================================== -->

      <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
          <div class="navbar-header" data-logobg="skin5">

            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            
            <a class="navbar-brand" href="index.php">
              <!-- Logo icon -->
              <b class="logo-icon">
                <!-- Dark Logo icon -->
                <img
                  src="assets/images/logo-sardana.png"
                  alt="homepage"
                  class="light-logo"
                  width="50"
                />
              </b>

              <!--End Logo icon -->

              <!-- Logo text -->

              <span class="logo-text ms-2">
                <!-- dark Logo text -->
                <h2 class="light-logo mt-2 page-logo">WMS</h2>
              </span>

            </a>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->

            <a
              class="nav-toggler waves-effect waves-light d-block d-md-none"
              href="javascript:void(0)">
              <i class="ti-menu ti-close"></i>
            </a>
          </div>

          <!-- ============================================================== -->
          <!-- End Logo -->
          <!-- ============================================================== -->

          <div
            class="navbar-collapse collapse"
            id="navbarSupportedContent"
            data-navbarbg="skin5"
          >

            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            
            <ul class="navbar-nav float-start me-auto">
              <li class="nav-item d-none d-lg-block">
                <a
                  class="nav-link sidebartoggler waves-effect waves-light"
                  href="javascript:void(0)"
                  data-sidebartype="mini-sidebar">
                  <i class="mdi mdi-menu font-24"></i>
                </a>
              </li>
            </ul>

            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->

            <ul class="navbar-nav float-end">
              <li class="nav-item dropdown">
                <a
                  class="
                    nav-link
                    dropdown-toggle
                    text-muted
                    waves-effect waves-dark
                    pro-pic
                  "
                  href="#"
                  id="navbarDropdown"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <img
                    src="assets/images/users.jpg"
                    alt="user"
                    class="rounded-circle nav-img"
                    width="31"
                  />

                  <?php echo $nama;?>
                  <span class="fa fa-angle-down"></span>

                </a>

                <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="javascript:void(0)">
                    <i class="mdi mdi-account me-1 ms-1"></i> My Profile
                  </a>
                  <a class="dropdown-item" href="javascript:void(0)">
                    <i class="mdi mdi-wallet me-1 ms-1"></i> My Balance
                  </a>
                  <a class="dropdown-item" href="javascript:void(0)">
                    <i class="mdi mdi-email me-1 ms-1"></i> Inbox
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="javascript:void(0)">
                    <i class="mdi mdi-settings me-1 ms-1"></i> Account
                    Setting
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="../logout.php">
                    <i class="fa fa-power-off me-1 ms-1"></i> Logout
                  </a>
                  <div class="dropdown-divider"></div>
                  <div class="ps-4 p-10">
                    <a
                      href="javascript:void(0)"
                      class="btn btn-sm btn-success btn-rounded text-white">
                      View Profile                    
                    </a>
                  </div>
                </ul>
              </li>
              <!-- ============================================================== -->
              <!-- User profile and search -->
              <!-- ============================================================== -->
            </ul>
          </div>
        </nav>
      </header>

      <!-- ============================================================== -->
      <!-- End Topbar header -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <aside class="left-sidebar" data-sidebarbg="skin5">

        <!-- Sidebar scroll-->

        <div class="scroll-sidebar">

          <!-- Sidebar navigation-->

          <nav class="sidebar-nav">
            <ul id="sidebarnav">
              <li class="sidebar-item hide-menu ">
                <div
                  class="sidebar-link profile-sidebar"
                  aria-expanded="false">
                  <img src="assets/images/users.jpg" alt="..." class="rounded-circle nav_img" >
                  <span class="hide-menu">Welcome, <b><?php echo $nama; ?></b></span>
                </div>
              </li>
              
              <li class="sidebar-item">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false">
                  <i class="fa fa-users"></i>
                  <span class="hide-menu">Master </span>
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="master-database.php" class="sidebar-link">
                      <i class="mdi mdi-server"></i>
                      <span class="hide-menu">Database</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="master-picker.php" class="sidebar-link">
                      <i class="mdi mdi-human-handsup"></i>
                      <span class="hide-menu">Picker</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="master-mobil.php" class="sidebar-link">
                      <i class="mdi mdi-car"></i>
                      <span class="hide-menu">Mobil</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="master-driver.php" class="sidebar-link">
                      <i class="mdi mdi-account"></i>
                      <span class="hide-menu">Driver</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="account.php" class="sidebar-link">
                      <i class="mdi mdi-account-plus"></i>
                      <span class="hide-menu">User Account</span>
                    </a>
                  </li>
                </ul>
              </li>
              
              <li class="sidebar-item">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                >
                <i class="fas fa-warehouse"></i>
                <span class="hide-menu"> WMS </span></a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="delivery.php" class="sidebar-link">
                      <i class="mdi mdi-truck-delivery"></i>
                      <span class="hide-menu"> Delivery </span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="javascript:void(0)" class="sidebar-link">
                      <i class="mdi mdi-backup-restore"></i>
                      <span class="hide-menu"> Retur Barang </span></a>
                  </li>
                </ul>
              </li>
              </li>

            </ul>
          </nav>
          <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
      </aside>

      <!-- ============================================================== -->
      <!-- End Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->

      <!-- ============================================================== -->
      <!-- Page wrapper  -->
      <!-- ============================================================== -->
      <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Delivery</h4>
              <div class="ms-auto text-end">
                <button class="btn btn-cyan" type="button" data-bs-toggle="modal" data-bs-target="#masterModal">Baru</button>
              </div>
            </div>
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->

        
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <!-- <div class="container-fluid">
          <div class="row">
            
          </div>
        </div> -->
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="px-3 row">
                  <form method="post" action="" role="form">
                  <div class="col-md-8">
                    <div class="form-group">
                      <div class="form-padding mb-2">
                        <div class="d-sm-inline-block d-md-flex">
                          <label class="mb-3 mb-md-0 mr-half centered d-md-flex">Tgl</label>
                          <input type="text" class="mr-3 col-md-2 col-4 mydatepicker"
                            name="awalStatus" value="<?=$awalTanggalStatus;?>">
                          <label class="centered d-md-flex">s/d.</label>
                          <input type="text" class="ml-3 col-md-2 col-4 mydatepicker"
                            name="akhirStatus" value="<?=$akhirTanggalStatus;?>">
                          <label class="px-2 centered d-md-flex"> Pilih Status</label>
                          <select id="status_pengiriman" class="shadow-none col-md-2"
                            name="status_pengiriman">
                            <option selected>Semua</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Dikirim">Dikirim</option>
                            <option value="Selesai">Selesai</option>
                          </select>
                          <button class="px-2 btn btn-success btn-sm text-white ml-half"
                            type="submit" name="filter_tgl_status">
                            Filter
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                </form>
                  <!-- <div class="col-md-7">
                    <div class="form-group">
                      <div class="col-md-4 d-flex">
                        
                      </div>
                    </div>
                  </div> -->
                </div>
                <div class="table-responsive">
                  <table id="table_delivery" class="table table-bordered table-condensed display compact" style="width:1800px;">
                    <thead>
                      <tr>
                        <th style="width:10px">No</th>
                        <th>No Transaksi</th>
                        <th>Nama (Owner)</th>
                        <th name='status-pengiriman'>Status</th>
                        <th>Tgl Transaksi</th>
                        <th>Tgl Terima</th>
                        <th>Tgl Kirim</th>
                        <th>Tgl Selesai</th>
                        <th>Nama Picker</th>
                        <th>Nama Driver</th>
                        <th>Plat Driver</th>
                        <th>Driver Customer</th>
                        <th>Plat Customer</th>
                        <th>Nama Sales</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Bootstrap Modals for Adding New No Transaksi -->
      <div class="modal fade in" id="masterModal" tabindex="-1" role="dialog" aria-labelledby="masterModallabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Delivery Baru</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="masterModallabel">&times;</span>
                  </button>
                </div>
                <!-- <form class="form-horizontal" id="form-submit" method="post" role="form"> -->
                <div class="modal-body">
                  <form method="post" role="form" id="form-filter" action="javascript:initFilter()">
                  <div class="form-padding mb-2">
                    <div class="d-sm-inline-block d-md-flex">
                      <label class="mr-half mb-2 centered d-block d-md-flex">Filter Tgl</label>
                      <input type="text" name="awalTanggal" value=<?=$awalTanggal?> class="mr-3 col-md-3 col-4 mydatepicker">
                      <label class="centered d-md-flex">s/d</label>
                      <input type="text" name="akhirTanggal" value=<?=$akhirTanggal?> class="ml-3 col-md-3 col-4 mydatepicker">
                      <button type="submit" class="btn btn-sm btn-success ml-half" name="filter_transaksi" id="cari_transaksi" >Cari</button>
                      <a class="btn btn-sm btn-warning ml-half" id="clear_transaksi">Clear</a>
                      <a class="btn btn-sm btn-info ml-half" id="select_all">Select All</a>
                    </div>
                  </div>
                  </form>
                <form class="form-horizontal" id="form-submit" method="post" role="form" action="javascript:initSubmit()">
                  <div class="form-padding d-block">
                    <label class="mr-half">Pilih No Transaksi: </label>
                    <div class="card border">
                      <div class="card-header">
                        Transaksi
                      </div>
                      <div class="card-body card-overflow" id="transaksi_container" style="padding:0;">

                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" name = "btn_submit" class="btn btn-primary">Simpan</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
                </form>
              </div>
          </div>
        </div>
      </div>

      <!-- Bootstrap Modals Edit Delivery -->

      <div class="modal fade" id="masterModalEdit" tabindex="-1" role="dialog" aria-labelledby="masterModallabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Delivery - Ubah</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="masterModallabel">&times;</span>
                  </button>
                </div>
                <form class="form-horizontal" id="form-edit" method="post" action="javascript:initEdit()" role="form">
                <div class="modal-body pt-none pb-none">
                  <div class="card mb-none">
                    <div class="card-body pb-none">
                      <div class="form-group row">
                        <label class="col-sm-4 control-label col-form-label">No Transaksi</label>
                        <div class="col-sm-8">
                          <input class="form-control" id="no_transaksi" name="no_transaksi" readonly="readonly">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 control-label col-form-label">Tgl Transaksi</label>
                        <div class="col-sm-8">
                          <input class="form-control" id="tgl_transaksi" name="tgl_transaksi" readonly="readonly">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 control-label col-form-label">Status</label>
                        <div class="col-sm-8">
                          <input class="form-control" id="status_delivery" readonly="readonly">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 control-label col-form-label">Nama (Owner)</label>
                        <div class="col-sm-8">
                          <input class="form-control" id="nama_owner" readonly="readonly">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 control-label col-form-label">Picker</label>
                        <div class="col-sm-8">
                          <select
                            class="select2 form-select shadow-none"
                            style="width: 100%; height: 36px"
                            id="select_picker" name="picker"
                          >
                            <!-- <option selected="true" disabled="disabled">Choose</option> -->
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 control-label col-form-label">Tgl Terima</label>
                        <div class="col-sm-8">
                          <input class="form-control" id="tgl_terima" readonly="readonly">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 control-label col-form-label">Tgl Kirim</label>
                        <div class="col-sm-8">
                          <input class="form-control mydatepicker" name="tgl_kirim" id="tgl_kirim" placeholder="dd-mm-yyyy">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 control-label col-form-label">Tgl Selesai</label>
                        <div class="col-sm-8">
                          <input class="form-control mydatepicker" name="tgl_selesai" id="tgl_selesai" placeholder="dd-mm-yyyy">
                        </div>
                      </div>
                      <div class="form-group row" id="jenis_pengiriman">
                        <label class="col-sm-6 control-label col-form-label mb-1">Jenis Pengiriman</label>
                        <div class="col-sm-9">
                          <div class="form-check">
                            <input id="kirim_cust" type="radio" class="form-check-input cp" name="jenis_pengiriman" onclick="enable_kirim()">
                            <label for="kirim_cust" class="form-check-label mb-0 cp">Kirim ke Customer</label>
                            <div class="form-group row mt-2">
                              <label class="col-sm-3 control-label col-form-label">Driver</label>
                              <div class="d-flex col-sm-7">
                                <select
                                  class="select2 shadow-none form-select"
                                  style="width: 100%; height: 36px"
                                  id="select_driver" name="select_driver"
                                >
                                </select>
                              </div>
                            </div>
                            <div class="form-group row mt-2">
                              <label class="col-sm-3 control-label col-form-label">No Plat</label>
                              <div class="d-flex col-sm-7">
                                <select
                                  class="select2 shadow-none form-select"
                                  style="width: 100%; height: 36px"
                                  id="select_plat" name="select_plat"
                                >
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-check">
                            <input id="ambil_sendiri" type="radio" class="form-check-input cp" name="jenis_pengiriman" onclick="enable_cust()">
                            <label for="ambil_sendiri" class="form-check-label mb-0 cp">Ambil Sendiri</label>
                            <div class="form-group row mt-2">
                              <label for="driver_cust" class="col-sm-3 control-label col-form-label">Driver</label>
                              <div class="d-flex col-sm-7">
                                <input id="driver_cust" name="driver_cust" type="text" class="form-control">
                              </div>
                            </div>
                            <div class="form-group row mt-2">
                              <label for="plat_cust" class="col-sm-3 control-label col-form-label">No Plat</label>
                              <div class="d-flex col-sm-7">
                                <input id="plat_cust" name="plat_cust" type="text" class="form-control">
                              </div>
                            </div>
                          </div>
                          <div class="form-check">
                            <input id="via_sales" type="radio" class="form-check-input cp" name="jenis_pengiriman" onclick="enable_sales()">
                            <label for="via_sales" class="form-check-label mb-0 cp">Via Sales</label>
                              <div class="form-group mt-2">
                                <select
                                  class="select2 shadow-none form-select"
                                  style="width: 100%; height: 36px" id="select_sales"
                                  name="nama_sales"
                                >
                                </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- <div class="form-group row">
                        
                      </div> -->
                    </div>
                  </div> 
                </div>

                <div class="modal-footer">
                  <button type="submit" name = "btn_submit" class="btn btn-primary">Simpan</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
                </form>
              </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- This Bundle includes working Modals Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>

    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>

    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>

    <!-- this page js -->
    <script src="assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>

    <script src="assets/extra-libs/multicheck/jquery.multicheck.js"></script>

    <script src="assets/extra-libs/DataTables/datatables.min.js"></script>

    <!-- Datepicker JS -->
    <script src="assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

    <script>

      // clear selected checkboxes inside add delivery baru
      $(document).on("click","#clear_transaksi", function() {
          const requiredCheckboxes = $('#masterModal .modal-body #card_container input[type="checkbox"]');
          requiredCheckboxes.each(function() {
          if ($(this).is(':checked')) {
            $(this).parent().parent().removeClass('bg-choose');
            $(this).parent().siblings().removeClass('bg-choose');
            $(this).prop('checked', false);
          }
        });
      });

      // select all checkbox inside delivery baru modals
      $(document).on("click","#select_all", function() {
          const requiredCheckboxes = $('#masterModal .modal-body #card_container input[type="checkbox"]');
          requiredCheckboxes.each(function() {
          if (!$(this).is(':checked')) {
            $(this).parent().parent().addClass('bg-choose');
            $(this).parent().siblings().addClass('bg-choose');
            $(this).prop('checked', true);
          }
        });
      });

      
      $(document).on('change','#masterModal .modal-body #card_container input[type="checkbox"]',function () {
        if ($(this).is(':checked')) {
          $(this).parent().parent().addClass('bg-choose');
          $(this).parent().siblings().addClass('bg-choose');
        } else {
          $(this).parent().parent().removeClass('bg-choose');
          $(this).parent().siblings().removeClass('bg-choose');
        }
      });

      var status = "<?=$status_pengiriman?>";

      function unique(list) {
        var result = [];
        $.each(list, function(i, e) {
          if ($.inArray(e, result) == -1) result.push(e);
        });
        return result;
      }

      var SelectedDriver = '';

      var SelectedDriverName = '';

      var SelectedPlatDriver = '';

      var SelectedCustPlat = '';

      var SelectedCustDriver = '';

      var SelectedSales = '';

      // window.onload = function() {
      //     $('#masterModal').modal('show');
      // }

      // adding loading spinners when ajax request 
      // $(document).ajaxStart(function(){
      //   $(".loader").show();
      // }).ajaxStop(function(){
      //   $(".loader").hide();
      // });
      
      $(document).ready(() => {
        $('#status_pengiriman option').each(function() {
          if($(this).val() == status) { 
            $(this).attr("selected","selected");    
          }
        });

        // getPicker();
        // getDriver();
        // getPlat();
        // getSales();

        $('.loader').hide();

        /*datepicker*/
        $(".mydatepicker").datepicker({
          format: 'dd-mm-yyyy',
          /* disable sunday in datepicker */
          daysOfWeekDisabled: "0",
          autoclose: true,
					todayHighlight: true
        });
        // $("#datepicker-autoclose").datepicker({
        //   autoclose: true,
        //   todayHighlight: true,
        // });
        // this function check if at least one of the checkbox is checked
        
          // if(requiredCheckboxes.is(':checked')) {
          //   $('#card_container').addClass('bg-diterima');
          // } else {
          //   $('#card_container').removeClass('bg-diterima');
          // }
  
        // requiredCheckboxes.change(function(){
        //   if(requiredCheckboxes.is(':checked')) {
        //       requiredCheckboxes.addClass('bg-diterima');
        //   } else {
        //       requiredCheckboxes.removeClass('bg-diterima');
        //   }
       

        var tableDelivery = $('#table_delivery').DataTable({
          "processing": true,
          "serverSide": true,
          "deferRender": true,
          "stateSave": true,
          "stateDuration": -1,
          "pageLength": 10,
          "ajax": {
            url: 'json/data_delivery.php',
          },
          "language": {
            "processing": '<div class="loader"></div>',
          },
          "order": [],
          "columnDefs": [
            { orderable: false, targets: [0, 1, 14] },
            // { width: '10%', targets: [3, 5]},
            // { width: '10%', targets: [4, 5, 6]},
            { width: '20%', targets: 2},
            { className: 'dt-center', targets: [0, 1, 3, 4, 5, 6, 7, 14]}
          ],
          "rowCallback": function(row, data, index) {
            const cellValue = data[3];
            if(cellValue == 'Diterima') {
              $('td:eq(3)', row).addClass("bg-diterima");
            } else if (cellValue == 'Dikirim') {
              $('td:eq(3)', row).addClass("bg-dikirim");
            } else {
              $('td:eq(3)', row).addClass("bg-selesai");
            }
          },
        });

        tableDelivery.on('draw.dt', () => {
          const PageInfo = $('#table_delivery').DataTable().page.info();
			    tableDelivery.column(0, { page: 'current' }).nodes().each((cell, i) => {
				    cell.innerHTML = i + 1 + PageInfo.start
			    })
        }) 

        $('#masterModal').on('shown.bs.modal', function(){
          // $('.loader').show();
          $.ajax({
            url: 'json/filterTanggalTransaksi.php',
            data: $('#form-filter').serialize(),
            type: 'post',
            beforeSend: () => {
              $('.loader').show();
            },
            // add loading icon
            success: result => {
              const res = $.parseJSON(result);
              // empty div container when ajax success
              $('#transaksi_container').empty();
              $('<div>').attr({
                    class: 'card-padding d-flex cp',
                    id: 'card_container'
                  }).append(
                    $('<div>').attr({
                      class: 'cp d-flex col-md-4 col-6 d-flex centered border-right border-bottom-grey'
                    }).append(
                      $('<label>').attr({
                        class: 'cp form-check-label col-9 m-0',
                      }).append('No Transaksi')
                    ),
                    (
                      $('<label>').attr({
                        class: 'cp form-check-label col-md-3 col-4 d-flex centered border-right border-bottom-grey word-break',
                      }).append('Tgl Transaksi')
                    ),
                    (
                      $('<label>').attr({
                        class: 'cp form-check-label px-2 col-md-6 col-12 border-bottom-grey ',
                      }).append('Nama (Owner)')
                    )
                ).appendTo('#transaksi_container');
              if(res.data.length > 0) {
                $.each(res.data, function (key, value) {
                  $('<div>').attr({
                    class: 'cp card-padding d-flex',
                    id: 'card_container'
                  }).append(
                    $('<div>').attr({
                      class: 'cp d-flex col-md-4 col-6 d-flex centered border-right border-bottom-grey'
                    }).append(
                      $('<input>').attr({
                        type: 'checkbox',
                        name: 'transaksi[]',
                        id: value[0],
                        class: 'cp form-check-input col-3 mr-3 mt-0',
                        value: ((value[3] != '') ? [value[0], value[1], value[2] + '(' + value[3] + ')'] : [value[0], value[1], value[2]])
                      }),
                      $('<label>').attr({
                        class: 'cp form-check-label col-9 m-0',
                        for: value[0],
                      }).append(value[0])
                    ),
                    (
                      $('<label>').attr({
                        class: 'cp form-check-label col-md-3 col-4 d-flex centered border-right border-bottom-grey word-break',
                        for: value[0],
                      }).append(value[1])
                    ),
                    (
                      $('<label>').attr({
                        class: 'cp form-check-label px-2 col-md-6 col-12 border-bottom-grey ',
                        for: value[0],
                      }).append((value[3] != '') ? value[2] + " (" + value[3] + ")" : value[2])
                    )
                  ).appendTo('#transaksi_container');
                });
              } else {
                alert('Data yang dicari tidak ditemukan!');
                $('#transaksi_container').empty();
              }
            },
            complete: () => {
              $('.loader').hide();
            },
            error: err => {
              console.error(err.statusText);
              $('.loader').hide();
            }
          })
        })

      });

      $('input[name="jenis_pengiriman"]').change(function () {
        if ($('#ambil_sendiri').is(':checked')) {
          $('#driver_cust').attr('required', true);
          $('#plat_cust').attr('required', true);
        } else {
          $('#driver_cust').removeAttr('required');
          $('#plat_cust').removeAttr('required');
        }
      });

      // remove required attributes when checkbox is checked
      // var requiredEditCheckboxes = $('#masterModalEdit .modal-body :checkbox[required]');
      //   requiredEditCheckboxes.change(function(){
      //     if(requiredEditCheckboxes.is(':checked')) {
      //         requiredEditCheckboxes.removeAttr('required');
      //     } else {
      //         requiredEditCheckboxes.attr('required', 'required');
      //     }
      // });

      function initFilter() {
        $.ajax({
          url: 'json/filterTanggalTransaksi.php',
          data: $('#form-filter').serialize(),
          type: 'post',
          beforeSend: () => {
            $('.loader').show();
          },
          success: result => {
            // $('.loader').hide();
            const res = $.parseJSON(result);
            // empty div container when ajax success
            $('#transaksi_container').empty();
            $('<div>').attr({
                  class: 'card-padding d-flex',
                  id: 'card_container'
                }).append(
                  $('<div>').attr({
                    class: 'cp d-flex col-md-4 col-6 d-flex centered border-right border-bottom-grey'
                  }).append(
                    $('<label>').attr({
                      class: 'cp form-check-label col-9 m-0',
                    }).append('No Transaksi')
                  ),
                  (
                    $('<label>').attr({
                      class: 'cp form-check-label col-md-3 col-4 d-flex centered border-right border-bottom-grey word-break',
                    }).append('Tgl Transaksi')
                  ),
                  (
                    $('<label>').attr({
                      class: 'cp form-check-label px-2 col-md-6 col-12 border-bottom-grey ',
                    }).append('Nama (Owner)')
                  )
              ).appendTo('#transaksi_container');
            // append html attribute
            if(res.data.length > 0) {
              $.each(res.data, function (key, value) {
                $('<div>').attr({
                  class: 'card-padding d-flex',
                  id: 'card_container'
                }).append(
                  $('<div>').attr({
                    class: 'cp d-flex col-md-4 col-6 d-flex centered border-right border-bottom-grey'
                  }).append(
                    $('<input>').attr({
                      type: 'checkbox',
                      name: 'transaksi[]',
                      id: value[0],
                      class: 'cp form-check-input col-3 mr-3 mt-0',
                      value: ((value[3] != '') ? [value[0], value[1], value[2] + '(' + value[3] + ')'] : [value[0], value[1], value[2]])
                    }),
                    $('<label>').attr({
                      class: 'cp form-check-label col-9 m-0',
                      for: value[0],
                    }).append(value[0])
                  ),
                  (
                    $('<label>').attr({
                      class: 'cp form-check-label col-md-3 col-4 d-flex centered border-right border-bottom-grey word-break',
                      for: value[0],
                    }).append(value[1])
                  ),
                  (
                    $('<label>').attr({
                      class: 'cp form-check-label px-2 col-md-6 col-12 border-bottom-grey ',
                      for: value[0],
                    }).append((value[3] != '') ? value[2] + " (" + value[3] + ")" : value[2])
                  )
                ).appendTo('#transaksi_container');
                
                
              });
            } else {
              alert('Data yang dicari tidak ditemukan!');
              $('#transaksi_container').empty()
            }
            // if(res.data.length < 0) {
            //   alert('Data tidak Ditemukan!');
            //   $('.loader').hide();
            // }
          },
          complete: () => {
            $('.loader').hide();
          },
          error: err => {
            console.error(err.statusText);
            $('.loader').hide();
          }
        })
      }
      
      

      function initSubmit() {
          $.ajax({
            type: "post",
            url: "json/insertNewDelivery.php",
            data: $('#form-submit').serialize(),
            success: result => {
              const res = $.parseJSON(result);
              if(res.success == 1) {
                // hide modals after submit data
                $('#masterModal').modal('hide');
                // reload datatable when ajax success returns success
                $('#table_delivery').DataTable().ajax.reload();
              } alert (res.message);
            },
            error: err => {
            console.error(err.statusText);
          }
        })
      }
   
      function initEdit() {
        $.ajax({
          type: "post",
          url: "json/editDelivery.php",
          data: $('#form-edit').serialize(),
          success: result => {
            const res = $.parseJSON(result);
            if(res.success == 1) {
            // hide modal after data submission
            $('#masterModalEdit').modal('hide');
            // reload datatable when ajax success returns success
            $('#table_delivery').DataTable().ajax.reload();
            } alert(res.message);
            
          },
          error: err => {
            console.error(err.statusText);
          }
        })
      }
      
      function getDelivery(transaksi) {
        $.ajax({
          type: "post",
          url: "json/getDelivery.php",
          data: {transaksi: transaksi},
          success: result => {
            const res = $.parseJSON(result);
            if(res.success == 1) {
              $('#no_transaksi').val(res.data.transaksi);
              $('#status_delivery').val(res.data.status);
              $('#tgl_transaksi').val(res.data.tgltransaksi);
              $('#nama_owner').val(res.data.nama);
              $('#tgl_terima').val(res.data.tglterima);
              $('#tgl_kirim').val(res.data.tglkirim);
              $('#tgl_selesai').val(res.data.tglselesai);
              const kirim = res.data.tglkirim;
              const selesai = res.data.tglselesai;
              const picker = res.data.picker;
              const namaPicker = res.data.namaPicker;
              SelectedDriver = res.data.driver;
              SelectedDriverName = res.data.namaDriver;
              SelectedPlatDriver = res.data.platDriver;
              SelectedCustPlat = res.data.platCust;
              SelectedCustDriver = res.data.driverCust;
              SelectedSales = res.data.sales;
              // check if the tglkirim value is null, prop disabled tgl selesai if null
              if(kirim == '') {
                $('#tgl_kirim').prop('disabled', false);
                $('#tgl_selesai').prop('disabled', true);
                $('#jenis_pengiriman').hide();
              } else {
                $('#tgl_kirim').prop('disabled', true);
                $('#tgl_selesai').prop('disabled', false);
                $('#jenis_pengiriman').show();
              }
              if(picker == null || picker == '') {
                $('#select_picker').prop('disabled', false);
                $("#select_picker").empty();
                getPicker();
              } else {
                $('#select_picker').prop('disabled', true);
                $('#select_picker').empty();
                $('<option>',
                {
                  html: namaPicker.concat(' (' + picker + ') '),
                  value: picker,
                }).appendTo('#select_picker');
              }
              if(SelectedCustPlat != '' || SelectedCustPlat != null) {
                $('#driver_cust').val(SelectedCustPlat);
              }
              if(SelectedCustDriver != '' || SelectedCustDriver != null) {
                $('#plat_cust').val(SelectedCustDriver);
              }
              $("#select_driver").empty();
              getDriver();
              $("#select_plat").empty();
              getPlat();
              $("#select_sales").empty();
              getSales();
            }
          },
          error: err => {
            console.error(err.statusText);
          }
        })
      }

      // } else if(picker == $('#select_picker option').val()) {
              

      function getPicker() {
        $.ajax({
          type: "post",
          url: "json/search_picker.php",
          success: result => {
            const res = $.parseJSON(result);
            if (res.success == 1) {
              if($('#select_picker').children().length == 0) {
                for (i = 0; i < res.data.length; ++i) {
                  $('<option>',
                  {
                    html: (res.data[i]).concat(' (' + res.id_data[i] + ')'),
                    value: res.id_data[i],
                  }).appendTo('#select_picker');
                }
              }   
            }
          },
          error: err => {
            console.error(err.statusText);
          }
        })
      }

      function getDriver() {
        $.ajax({
          type: "post",
          url: "json/search_driver.php",
          success: result => {
            const res = $.parseJSON(result);
            if (res.success == 1) {
              if($('#select_driver').children().length == 0) {
                if(SelectedDriver != '') {
                  $('<option>',
                    {
                      html: SelectedDriverName.concat(' (' + SelectedDriver + ')'),
                      value: SelectedDriver,
                    }).appendTo('#select_driver');
                }
                for (i = 0; i < res.data.length; ++i) {
                  if(res.id_data[i] != SelectedDriver) {
                  $('<option>',
                    {
                      html: (res.data[i]).concat(' (' + res.id_data[i] + ')'),
                      value: res.id_data[i],
                    }).appendTo('#select_driver');
                  }
                }
                
              }
            }
          },
          error: err => {
            console.error(err.statusText);
          }
        })
      }

      function getPlat() {
        $.ajax({
          type: "post",
          url: "json/search_plat.php",
          success: result => {
            const res = $.parseJSON(result);
            if (res.success == 1) {
              if($('#select_plat').children().length == 0) {
                if(SelectedPlatDriver != '') {
                  $('<option>',
                    {
                      html: SelectedPlatDriver,
                      value: SelectedPlatDriver,
                    }).appendTo('#select_plat');
                }
                for (i = 0; i < res.data.length; ++i) {
                  if(res.data[i] != SelectedPlatDriver) {
                    $('<option>',
                    {
                      html: res.data[i],
                      value: res.data[i],
                    }).appendTo('#select_plat');
                  }
                }
              }
              
            }
          },
          error: err => {
            console.error(err.statusText);
          }
        })
      }

      function getSales() {
        $.ajax({
          type: "post",
          url: "json/search_sales.php",
          success: result => {
            const res = $.parseJSON(result);
            if (res.success == 1) {
              if($('#select_sales').children().length == 0) {
                if(SelectedSales != '') {
                  $('<option>',
                    {
                      html: SelectedSales,
                      value: SelectedSales,
                    }).appendTo('#select_sales');
                }
                // lowercase array values
                const lower = (res.data).map(v => v.toLowerCase());
                // remove duplicates in array
                const test = unique(lower);
                
                for (i = 0; i < test.length; ++i) {
                  if(test[i] != SelectedSales) {
                    $('<option>',
                    {
                      html: test[i],
                      value: test[i],
                    }).appendTo('#select_sales');
                  }
                }
              }
            }
          },
          error: err => {
            console.error(err.statusText);
          }
        })
      }

      if(!$('#kirim_cust').is(':checked')) {
          $('#select_driver').prop('disabled', true);
          $('#select_plat').prop('disabled', true);
      } 

      if(!$('#ambil_sendiri').is(':checked')) {
          $('#driver_cust').prop('disabled', true);
          $('#plat_cust').prop('disabled', true);
      } 

      if(!$('#via_sales').is(':checked')) {
          $('#select_sales').prop('disabled', true);
      }

      function enable_kirim() {
        $('#select_driver').prop('disabled', false);
        $('#select_plat').prop('disabled', false);
        $('#driver_cust').prop('disabled', true);
        $('#plat_cust').prop('disabled', true);
        $('#select_sales').prop('disabled', true);
      } 

      function enable_cust() {
        $('#driver_cust').prop('disabled', false);
        $('#plat_cust').prop('disabled', false);
        $('#select_driver').prop('disabled', true);
        $('#select_plat').prop('disabled', true);
        $('#select_sales').prop('disabled', true);
      } 

      function enable_sales() {
        $('#select_sales').prop('disabled', false);
        $('#driver_cust').prop('disabled', true);
        $('#plat_cust').prop('disabled', true);
        $('#select_driver').prop('disabled', true);
        $('#select_plat').prop('disabled', true);
      } 

      // if($('.form-check-input:checked[type="radio"]').checked) {
      //   alert('Button Checked');
      // }

    </script>

  </body>

</html>
