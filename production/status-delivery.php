<?php
    session_start();
    require_once '../function.php';
    date_default_timezone_set('Asia/Jakarta');
    // cek apakah user sudah login, apabila belum login arahkan user ke laman login
    if(!isset($_SESSION['user_login'])) {
      header("location:../login.php");  
    }
    $user_segmen = $_SESSION['segmen_user'];
    // var_dump($user_segmen);
    $nama = $_SESSION['user_login'];
    $user_data = $_SESSION['user_server'];
    $tanggalAwal = date('d-m-Y');
    $tanggalAkhir = date('d-m-Y');
    // $sales = $_SESSION['sales_force'];
    // $statusAwalTransaksi = date('d-m-Y');
    // $statusAkhirTransaksi = date('d-m-Y');
    // $statusAwalTerima = date('d-m-Y');
    // $statusAkhirTerima = date('d-m-Y');
    // $statusAwalKirim = date('d-m-Y');
    // $statusAkhirKirim = date('d-m-Y');
    // $statusAwalSelesai = date('d-m-Y');
    // $statusAkhirSelesai = date('d-m-Y');
    // $tglTerima = date('d-m-Y');
    // $tglKirim = date('d-m-Y');
    // $waktuKirim = date('H:i');
    // $waktuTerima = date('H:i');
    $state = '';
    // filter noTransaksi
    if(isset($_REQUEST['filter_tgl_status'])){
      $state = $_POST['status_transaksi'];
      $_SESSION['FilterTglAwal'] = $_POST['filter_awal'];
      $_SESSION['FilterTglAkhir'] = $_POST['filter_akhir'];
    }

    $_SESSION['status'] = $state;

    if(isset($_SESSION['FilterTglAwal'])) $tanggalAwal = $_SESSION['FilterTglAwal'];
    if(isset($_SESSION['FilterTglAkhir'])) $tanggalAkhir = $_SESSION['FilterTglAkhir'];

    // if(isset($_REQUEST['filter_tgl'])){
    //   $state = $_REQUEST['enable_date'];
    //   switch($state) {
    //     case 'terima_on':
    //       $status = 'transaksi_on';
    //       $_SESSION['StatusFilterTransaksi'] = $status;
    //       $_SESSION['FilterStatusAwalTransaksi'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAkhirTransaksi'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAwalTerima'] = $_POST['statusAwalTerima'];
    //       $_SESSION['FilterStatusAkhirTerima'] = $_POST['statusAkhirTerima'];
    //       $_SESSION['FilterStatusAwalKirim'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAkhirKirim'] = date('d-m-Y');
    //       break;
    //     case 'kirim_on':
    //       $status = 'kirim_on';
    //       $_SESSION['StatusFilterTransaksi'] = $status;
    //       $_SESSION['FilterStatusAwalTransaksi'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAkhirTransaksi'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAwalTerima'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAkhirTerima'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAwalKirim'] = $_POST['statusAwalKirim'];
    //       $_SESSION['FilterStatusAkhirKirim'] = $_POST['statusAkhirKirim'];
    //       $_SESSION['FilterStatusAwalSelesai'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAkhirSelesai'] = date('d-m-Y');
    //       break;
    //     case 'selesai_on':
    //       $status = 'selesai_on';
    //       $_SESSION['StatusFilterTransaksi'] = $status;
    //       $_SESSION['FilterStatusAwalTransaksi'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAkhirTransaksi'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAwalTerima'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAkhirTerima'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAwalKirim'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAkhirKirim'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAwalSelesai'] = $_POST['statusAwalSelesai'];
    //       $_SESSION['FilterStatusAkhirSelesai'] = $_POST['statusAkhirSelesai'];
    //       break;
    //     default:
    //       $status = 'transaksi_on';
    //       $_SESSION['StatusFilterTransaksi'] = $status;
    //       $_SESSION['FilterStatusAwalTransaksi'] = $_POST['statusAwalTransaksi'];
    //       $_SESSION['FilterStatusAkhirTransaksi'] = $_POST['statusAkhirTransaksi'];
    //       $_SESSION['FilterStatusAwalTerima'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAkhirTerima'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAwalKirim'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAkhirKirim'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAwalSelesai'] = date('d-m-Y');
    //       $_SESSION['FilterStatusAkhirSelesai'] = date('d-m-Y');
    //       break;
    //   }
    // }

    // if(isset($_SESSION['FilterStatusAwalTransaksi'])) $statusAwalTransaksi = $_SESSION['FilterStatusAwalTransaksi'];
    // if(isset($_SESSION['FilterStatusAkhirTransaksi'])) $statusAkhirTransaksi = $_SESSION['FilterStatusAkhirTransaksi'];
    // if(isset($_SESSION['FilterStatusAwalTerima'])) $statusAwalTerima = $_SESSION['FilterStatusAwalTerima'];
    // if(isset($_SESSION['FilterStatusAkhirTerima'])) $statusAkhirTerima = $_SESSION['FilterStatusAkhirTerima'];
    // if(isset($_SESSION['FilterStatusAwalKirim'])) $statusAwalKirim = $_SESSION['FilterStatusAwalKirim'];
    // if(isset($_SESSION['FilterStatusAkhirKirim'])) $tglAkhirKirim = $_SESSION['FilterStatusAkhirKirim'];
    // if(isset($_SESSION['FilterStatusAwalSelesai'])) $statusAwalSelesai = $_SESSION['FilterStatusAwalSelesai'];
    // if(isset($_SESSION['FilterStatusAkhirSelesai'])) $tglAkhirSelesai = $_SESSION['FilterStatusAkhirSelesai'];
    
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

    <!-- Bootstrap Timepicker CSS -->
    
    <link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css"/>
    
    <!-- Bootstrap Datetimepicker CSS -->

    <link rel="stylesheet" type="text/css" href="assets/libs/bootstrap4-datetimepicker/bootstrap-datetimepicker.min.css"/>
    
    <!-- Google Font -->
    
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">

    <style>

      .mt-4-half {
          margin-top: 2.25rem;
      }

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

      body {
        overflow:auto;
      }

      @media (min-width: 768px) {
        .mr-md-64 {
          margin-right: 64px;
        }

        .fs12-scaled {
          font-size: 12px !important;
        }

        .btn-scaled {
          padding: 8px 16px;
        }

        .fs14-scaled {
          font-size: 14px !important;
        }

        .fs16-scaled {
          font-size: 16px !important;
        }

        .custom-scaled {
          font-size: 14px !important;
        }
      }

      @-moz-document url-prefix() {
        .mb-moz {
          margin-bottom: 0.765rem !important;
        }
      }

      .mb-moz {
        margin-bottom: 0.525rem;
      }

      div.dataTables_wrapper div.dataTables_paginate ul.pagination {
        /* margin: 2px 0;
        white-space: wrap;
        justify-content: flex-end; */
        flex-wrap: wrap;
      }

      .ml-custom-right-10 {
        margin-left: 10px;
      }

      
      .self-centered {
        text-align: center;
        align-self: center !important;
      }

      .mt-4-half {
        margin-top: 2.25rem;
      }
      
      .bg-belum-diterima { 
        background-color: #fcb1ac !important;
      }

      .bg-diterima {
        background-color: #ff9933 !important;
      }

      .bg-dikirim {
        background-color: #7aff8c !important;
      }

      .bg-selesai {
        background-color: #989898 !important;
      }

      .highlight {
        background-color: yellowgreen !important;
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
        content: '*';
        color: red;
        margin-right: 3px;
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

      .custom-scaled {
        font-size: 14px;
      }

      .fs12-scaled {
        font-size: 13px;
      }

      .fs14-scaled {
        font-size: 13px;
      }

      .btn-scaled {
        padding: 6px 12px;
      }

      .mr-sm-3half-left {
        margin-right: -1.5rem;
      }

      .ml-1em {
        margin-left: 0.675em;
      }
      
      .b-bottom {
        border-bottom: 3px solid #e9ecef;
      }

      @media (max-width: 768px) {
        .mr-sm-3half-left {
          margin-right: 0rem;
        }

        .ml-1em {
          margin-left: 0;
        }

        .ml-custom-right-10 {
          margin-left: -10px;
        }

      }

      .ml-custom-right-16 {
        margin-left: -16px;
      }

      @media (min-width: 768px) {
        .ml-custom-right-16 {
          margin-left: -48px;
        }
      }

      div.dataTables_wrapper div.dataTables_paginate ul.pagination {
        /* margin: 2px 0;
        white-space: wrap;
        justify-content: flex-end; */
        flex-wrap: wrap;
      }

    </style>

  </head>

  
  <body>

    <div class='loader'></div>
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>

    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >

      <?php require_once 'header-navbar.php'?>

      <aside class="left-sidebar" data-sidebarbg="skin5">

        <div class="scroll-sidebar">
          <?php require_once 'sidebar.php'?>
        </div>
      </aside>

      <div class="page-wrapper">
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Status Delivery</h4>
              <div class="ms-auto text-end">
                <!-- <button class="btn btn-cyan" type="button" data-bs-toggle="modal" data-bs-target="#masterModal">Baru</button> -->
              </div>
            </div>
          </div>
        </div>

        <!-- <div class="container-fluid">
          <div class="row">
            
          </div>
        </div> -->
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-body d-flex px-4 pb-2 b-bottom">
                <!-- erase this px-3, causing trouble at styling -->
                <div class="container px-3">
                  <form method="post" action="" role="form">
                  <div class="row">
                    <div class="col-md-5 col-12">
                      <div class="form-group">
                        <div class="ml-right-16 mb-2">
                          <!-- Change the date filtering into the newer version -->
                          <!-- <div class="d-sm-inline-block d-md-flex mb-3">
                            <label class="mb-3 mb-md-0 mr-half centered d-md-flex d-block">Filter Tgl Transaksi</label>
                            <input type="radio" class="cp mr-8" id="filter_transaksi" name="enable_date" value="transaksi_on" onclick="enable_transaksi()">
                            <input type="text" class="col-md-3 col-4 mydatepicker"
                              name="statusAwalTransaksi" id="awal_transaksi" value="<?=$statusAwalTransaksi?>" autocomplete="off">
                            <label class="ml-3 centered d-md-flex" style="margin-right:5px;">s/d</label>
                            <input type="text" class="col-md-3 col-4 mydatepicker"
                              name="statusAkhirTransaksi" id="akhir_transaksi" value="<?=$statusAkhirTransaksi?>" autocomplete="off">
                          </div>
                          <div class="d-sm-inline-block d-md-flex mb-3">
                            <label class="mb-3 mb-md-0 mr-16em-half centered d-md-flex d-block">Filter Tgl Terima</label>
                            <input type="radio" class="cp mr-8" id="filter_terima" name="enable_date" value="terima_on" onclick="enable_terima()">
                            <input type="text" class="col-md-3 col-4 mydatepicker"
                              name="statusAwalTerima" id="awal_terima"  value="<?=$statusAwalTerima?>" autocomplete="off">
                            <label class="ml-3 centered d-md-flex" style="margin-right:5px;">s/d</label>
                            <input type="text" class="col-md-3 col-4 mydatepicker"
                              name="statusAkhirTerima" id="akhir_terima" value="<?=$statusAkhirTerima?>" autocomplete="off">
                          </div>
                          <div class="d-sm-inline-block d-md-flex mb-3">
                            <label class="mb-3 mb-md-0 mr-25em-half centered d-md-flex d-block">Filter Tgl Kirim</label>
                            <input type="radio" class="cp mr-8" id="filter_kirim" name="enable_date" value="kirim_on" onclick="enable_kirim()">
                            <input type="text" class="col-md-3 col-4 mydatepicker"
                              name="statusAwalKirim" id="awal_kirim"  value="<?=$statusAwalKirim?>" autocomplete="off">
                            <label class="ml-3 centered d-md-flex" style="margin-right:5px;">s/d</label>
                            <input type="text" class="col-md-3 col-4 mydatepicker"
                              name="statusAkhirKirim" id="akhir_kirim" value="<?=$statusAkhirKirim?>" autocomplete="off">
                          </div>
                          <div class="d-sm-inline-block d-md-flex">
                            <label class="mb-3 mb-md-0 mr-half centered d-md-flex mr-15em d-block">Filter Tgl Selesai</label>
                            <input type="radio" class="cp mr-8" id="filter_selesai" name="enable_date" value="selesai_on" onclick="enable_selesai()">
                            <input type="text" class="col-md-3 col-4 mydatepicker"
                              name="statusAwalSelesai" id="awal_selesai"  value="<?=$statusAwalSelesai?>" autocomplete="off">
                            <label class="ml-3 centered d-md-flex" style="margin-right:5px;">s/d</label>
                            <input type="text" class="col-md-3 col-4 mydatepicker"
                              name="statusAkhirSelesai" id="akhir_selesai" value="<?=$statusAkhirSelesai?>" autocomplete="off">
                          </div> -->
                          <div class="d-flex mb-3" style="align-items:center">
                            <label class="mb-0 mr-half fs14-scaled align-self-center d-flex">Pilih Transaksi : </label>
                            <select
                              class="cp select2 shadow-none mr-12 custom-scaled"
                              id="select_status" name="status_transaksi">
                              <!-- <option value="" selected="selected" disabled>Pilih Status</option> -->
                              <option value="semua">Semua</option>
                              <option value="terima">Terima</option>
                              <option value="kirim">Kirim</option>
                              <option value="selesai">Selesai</option>
                              <!-- <option value="selesai">Selesai</option> -->
                            </select>
                          </div>
                          <div class="d-block d-md-flex mb-3" style="align-items:center;">
                            <label class="fs14-scaled mb-2 mb-md-0 mr-half centered d-block d-md-flex">
                              Tanggal : 
                            </label>
                            <input type="text" class="col-4 col-md-3 mydatepicker" name="filter_awal" 
                              id="filter_awal" value="<?=$tanggalAwal?>" autocomplete="off">
                            <label class="ml-3 centered d-md-flex mb-0" style="margin-right:5px;">s/d</label>
                            <input type="text" class="col-4 col-md-3 mydatepicker"
                              name="filter_akhir" value="<?=$tanggalAkhir?>" id="filter_akhir" autocomplete="off">
                            <button class="px-2 btn btn-success btn-sm text-white ml-half"
                              type="submit" name="filter_tgl_status">
                              Filter
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- <div class = "ml-custom-right-16 col-md-2 col-sm-12">
                      <button class="px-2 btn btn-success btn-sm text-white"
                        type="submit" name="filter_tgl" id="btn_filter">
                        Filter
                      </button>
                    </div> -->
                  </form>
                  </div>

                </div>
                  <!-- <div class="col-md-7">
                    <div class="form-group">
                      <div class="col-md-4 d-flex">
                        
                      </div>
                    </div>
                  </div> -->
                </div>
                <div class="table-responsive mt-3">
                  <table id="table_delivery" class="table table-bordered display compact">
                    <thead>
                      <tr>
                        <th style="width:10px">No</th>
                        <th>No Transaksi</th>
                        <th style="min-width:350px;">Customer</th>
                        <th name='status-pengiriman'>Status</th>
                        <th>Tgl Transaksi</th>
                        <th>Tgl Terima</th>
                        <th>Picker</th>
                        <th>Tgl Kirim</th>
                        <th>Tgl Selesai</th>
                        <th>Jenis Pengiriman</th>
                        <th>Wilayah</th>
                        <th>Nama Ekspedisi</th>
                        <th>Nama Driver</th>
                        <th>Plat Driver</th>
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
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- Bootstrap Modals for Edit Status Pengiriman -->
                <div class="modal fade" id="masterModalEdit" tabindex="-1" role="dialog" aria-labelledby="masterModallabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Edit Status Pengiriman</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true" id="masterModallabel">&times;</span>
                        </button>
                      </div>
                      <form class="form-horizontal" id="form-edit" method="post" action="javascript:editTransaksi()" role="form">
                        <div class="modal-body pt-none pb-none">
                          <div class="card-body pb-none">
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label">No Transaksi</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="no_transaksi" name="no_transaksi" readonly="readonly">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label">Nama Sales</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="nama_sales" name="nama_sales" readonly="readonly">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label">ID Transaksi</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="id_transaksi" name="id_transaksi" readonly="readonly">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label">Customer</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="nama_customer" name="nama_customer" readonly="readonly">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label">Tgl Transaksi</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="tgl_transaksi" name="tgl_transaksi" readonly="readonly">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label">Status Transaksi</label>
                              <div class="d-flex col-sm-6">
                                <select
                                  class="select2 shadow-none form-select cp"
                                  style="width: 100%; height: 36px"
                                  id="ganti_status" name="select_status" onchange="javascript:checkStatus()"
                                >
                                  <option value="" selected="selected" disabled>Pilih Status Pengiriman</option>
                                  <option value="1">Diterima</option>
                                  <option value="2">Dikirim</option>
                                  <option value="3">Selesai</option>
                                </select>
                              </div>
                            </div>
                            <!-- <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label">Tgl Terima</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control mydatepicker" name="tanggal_terima" id="tanggal_terima">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label">Waktu Terima</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control mytimepicker" name="waktu_terima" id="waktu_terima">
                              </div>
                            </div> -->
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label">Jadwal Terima</label>
                              <div class="col-sm-6">
                                <div class="input-group date datetimepicker">
                                  <input class="form-control" type="text" name="tanggal_terima" id="tanggal_terima">
                                  <div class="input-group-append">
                                    <span class="input-group-text input-group-addon" style="padding:0.6rem 0.75rem;">
                                      <span class="fa fa-calendar"></span>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label">Select Picker</label>
                              <div class="d-flex col-sm-6">
                                <select
                                  class="select2 shadow-none form-select cp"
                                  style="width: 100%; height: 36px"
                                  id="select_picker" name="select_picker"
                                >
                                <option value="" selected="selected" disabled>Pilih Picker</option>
                                </select>
                              </div>
                            </div>
                            <!-- <div class="form-group row"> 
                              <label class="col-sm-4 control-label col-form-label">Tgl Kirim</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control mydatepicker" name="tanggal_kirim" id="tanggal_kirim">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label">Waktu Kirim</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control mytimepicker" name="waktu_kirim" id="waktu_kirim">
                              </div>
                            </div> -->
                          <div id="section-dikirim">
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label">Jadwal Kirim</label>
                              <div class="col-sm-6">
                                <div class="input-group date datetimepicker">
                                  <input class="form-control" type="text" name="tanggal_kirim" id="tanggal_kirim">
                                  <div class="input-group-append">
                                    <span class="input-group-text input-group-addon" style="padding:0.6rem 0.75rem;">
                                      <span class="fa fa-calendar"></span>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label">Jenis Pengiriman</label>
                              <div class="d-flex col-sm-6">
                                <select
                                  class="select2 shadow-none form-select cp"
                                  style="width: 100%; height: 36px"
                                  id="select_pengiriman" name="select_pengiriman"
                                  autocomplete="off" onchange="javascript:jenisPengiriman()"
                                > 
                                  <option value="" selected="selected" disabled>Pilih Jenis Pengiriman</option>
                                  <option value="Kirim Customer">Kirim ke Customer</option>
                                  <option value="Ambil Sendiri">Ambil Sendiri</option>
                                  <option value="Via Sales">Via Sales</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group row" id="section_wilayah">
                              <label class="col-sm-4 control-label col-form-label">Wilayah</label>
                              <div class="col-sm-6">
                                <select
                                    class="select2 shadow-none form-select cp"
                                    id="wilayah_pengiriman" name="wilayah_pengiriman"
                                    autocomplete="off" onchange="javascript:tempat_pengiriman()"
                                  >
                                  <option value="" selected="selected" disabled>Pilih Wilayah Pengiriman</option>
                                  <option value="Dalam Kota">Dalam Kota</option>
                                  <option value="Luar Kota">Luar Kota</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group row" id="ekspedisi">
                              <label class="col-sm-4 control-label col-form-label">Nama Ekspedisi</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="nama_ekspedisi" name="nama_ekspedisi">
                              </div>
                            </div>
                            <div class="form-group row" id="driver_section">
                              <label class="col-md-4 col-12 control-label col-form-label">Nama Driver</label>
                              <div class="col-md-6 col-10">
                                <input type="text" class="form-control" id="nama_driver" name="nama_driver">
                              </div>
                              <div class="col-2 d-flex">
                                <select
                                    id="select_driver" name="select_driver"
                                    style="width:40px; text-align:left; padding: 0 5px;"
                                    class="self-centered cp remove-arrow-dropdown"
                                    onclick="javascript:checkSelectedDriver()"
                                >
                                  <option selected disabled value="">...</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group row" id="plat_section">
                              <label class="col-md-4 col-12 control-label col-form-label">No. Plat</label>
                              <div class="col-md-6 col-10">
                                <input type="text" class="form-control" id="no_plat" name="no_plat">
                              </div>
                              <div class="col-md-2 col-2 d-flex">
                                <select
                                    id="select_plat" name="select_plat"
                                    style="width:40px; text-align:left; padding: 0 5px;"
                                    class="self-centered cp remove-arrow-dropdown"
                                    onclick="javascript:checkSelectedPlat()"
                                >
                                  <option selected disabled value="">...</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div id="section-selesai">
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label">Jadwal Selesai</label>
                              <div class="col-sm-6">
                                <div class="input-group date datetimepicker">
                                  <input class="form-control" type="text" name="tanggal_selesai" id="tanggal_selesai">
                                  <div class="input-group-append">
                                    <span class="input-group-text input-group-addon" style="padding:0.6rem 0.75rem;">
                                      <span class="fa fa-calendar"></span>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" name = "btn_submit" class="btn btn-primary">Update</button>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
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

    <!--Moment JavaScript, needed for bootstrap datetimepicker to work well -->
    <script src="js/moment.js"></script>

    <!-- this page js -->
    <script src="assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>

    <script src="assets/extra-libs/multicheck/jquery.multicheck.js"></script>

    <script src="assets/extra-libs/DataTables/datatables.min.js"></script>

    <!-- Bootstrap Datepicker JS -->
    <script src="assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

    <!-- Bootstrap Timepicker JS -->
    <script src="assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    
    <!-- Bootstrap Datetimepicker JS -->
    <script src="assets/libs/bootstrap4-datetimepicker/bootstrap-datetimepicker.js"></script>

    <script>

      var today = '<?php echo date('d-m-Y H:i') ?>';

      var state = '<?php echo $state ?>';

      if(state == '' || state == 'semua') {
        $('#select_status option[value="semua"]').prop('selected', true);
      } else if(state == 'terima') {
        $('#select_status option[value="terima"]').prop('selected', true);
      } else if(state == 'kirim'){
        $('#select_status option[value="kirim"]').prop('selected', true);
      } else {
        $('#select_status option[value="selesai"]').prop('selected', true);
      }

      function checkSelectedDriver() {
        if($('#select_driver option:selected').val() != '') {
          $('#nama_driver').val($('#select_driver').val());
          $('#select_driver').val('');
        }
      } 
      
      function checkSelectedPlat() {
        if($('#select_plat option:selected').val() != '') {
          $('#no_plat').val($('#select_plat').val());
          $('#select_plat').val('');
        }
      }

      $(document).ready(() => {
        getPicker();
        getDriver();
        getPlat();
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

        // timepicker 
        $(".mytimepicker").timepicker({
          timeFormat: 'HH:mm',
          // defaultTime: 'current',
          minuteStep: 15,
          maxHours: 24,
          showInputs: true,
          showMeridian: false,
          icons: {
            up: 'fas fa-angle-up',
            down: 'fas fa-angle-down'
          }
        })

        // bootstrap4 datetimepicker
        $(".datetimepicker").datetimepicker({
          format: 'DD-MM-YYYY HH:mm',
          icons: {
            time: 'fas fa-clock',
            date: 'fas fa-calendar',
            up: 'fas fa-chevron-up',
            down: 'fas fa-chevron-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'fas fa-check',
            clear: 'fas fa-trash',
            close: 'fas fa-times'
          }
        })
        
        if(state == '' || state == 'transaksi_on') {
          $('#filter_transaksi').prop('checked', true);
          $('#awal_transaksi').prop('disabled', false);
          $('#akhir_transaksi').prop('disabled', false);
        } else if(state == 'terima_on') {
          $('#filter_terima').prop('checked', true);
        } else if(state == 'kirim_on'){
          $('#filter_kirim').prop('checked', true);
        } else {
          $('#filter_selesai').prop('checked', true);
        }

        // this filtering event is unused yet
        // if(!$('#filter_transaksi').is(':checked')) {
        //     $('#awal_transaksi').prop('disabled', true);
        //     $('#akhir_transaksi').prop('disabled', true);
        //   } else {
        //     $('#awal_transaksi').prop('disabled', false);
        //     $('#akhir_transaksi').prop('disabled', false);
        // }

        // if(!$('#filter_terima').is(':checked')) {
        //     $('#awal_terima').prop('disabled', true);
        //     $('#akhir_terima').prop('disabled', true);
        //   } else {
        //     $('#awal_terima').prop('disabled', false);
        //     $('#akhir_terima').prop('disabled', false);
        // }

        // if(!$('#filter_kirim').is(':checked')) {
        //     $('#awal_kirim').prop('disabled', true);
        //     $('#akhir_kirim').prop('disabled', true);
        //   } else {
        //     $('#awal_kirim').prop('disabled', false);
        //     $('#akhir_kirim').prop('disabled', false);
        // }

        // if(!$('#filter_selesai').is(':checked')) {
        //     $('#awal_selesai').prop('disabled', true);
        //     $('#akhir_selesai').prop('disabled', true);
        //   } else {
        //     $('#awal_selesai').prop('disabled', false);
        //     $('#akhir_selesai').prop('disabled', false);
        // }

        var tableDelivery = $('#table_delivery').DataTable({
          "processing": true,
          "serverSide": true,
          "deferRender": true,
          "stateSave": true,
          "stateDuration": -1,
          "pageLength": 25,
          "scrollY": '300px',
          "scrollX": '1200px',
          "ajax": {
            url: 'json/data_delivery.php',
          },
          "language": {
            "processing": '<div class="loader"></div>',
          },
          "order": [],
          "columnDefs": [
            { orderable: false, targets: [0, 15] },
            // { width: '10%', targets: [3, 5]},
            // { width: '10%', targets: [4, 5, 6]},
            { width: '125px', targets: [4, 5, 7, 8]},
            { width: '120px', targets: 1},
            { width: '100px', targets: 6},
            { width: '110px', targets: [9, 10, 11, 12, 13, 14]},
            { className: 'dt-center', targets: [0, 1, 3, 4, 5, 6, 7, 8, 9, 10, 15]},
            { targets: 3,
              render: function(data){
                if(data == 1)
                  return '<b>Diterima</b>'
                else if (data == 2)
                  return '<b>Dikirim</b>'
                else if(data == 3)
                  return '<b>Selesai</b>'
                else 
                  return ''
              }}
          ],
          "rowCallback": function(row, data, index) {
            const cellValue = data[3];
            if(cellValue == 1) {
              $('td:eq(3)', row).addClass("bg-diterima");
            } else if (cellValue == 2) {
              $('td:eq(3)', row).addClass("bg-dikirim");
            } else if (cellValue == 3) {
              $('td:eq(3)', row).addClass("bg-selesai");
            } else {
              $('td:eq(3)', row).addClass("bg-belum-diterima");
            }
          },
        });

        tableDelivery.page('first').draw('page');

        tableDelivery.on('draw.dt', () => {
          const PageInfo = $('#table_delivery').DataTable().page.info();
			    tableDelivery.column(0, { page: 'current' }).nodes().each((cell, i) => {
				    cell.innerHTML = i + 1 + PageInfo.start
			    })
        })
      });
      
      // for ui/ux purposes only, enable datetime when radio button is clicked
      // this function is not used in this template
      // function enable_transaksi() {
      //   $('#awal_transaksi').prop('disabled', false);
      //   $('#akhir_transaksi').prop('disabled', false);
      //   $('#awal_terima').prop('disabled', true);
      //   $('#akhir_terima').prop('disabled', true);
      //   $('#awal_kirim').prop('disabled', true);
      //   $('#akhir_kirim').prop('disabled', true); 
      //   $('#awal_selesai').prop('disabled', true);
      //   $('#akhir_selesai').prop('disabled', true);    
      // }

      // function enable_terima() {
      //   $('#awal_transaksi').prop('disabled', true);
      //   $('#akhir_transaksi').prop('disabled', true);
      //   $('#awal_terima').prop('disabled', false);
      //   $('#akhir_terima').prop('disabled', false);
      //   $('#awal_kirim').prop('disabled', true);
      //   $('#akhir_kirim').prop('disabled', true);
      //   $('#awal_selesai').prop('disabled', true);
      //   $('#akhir_selesai').prop('disabled', true); 
      // }
      
      // function enable_kirim() {
      //   $('#awal_transaksi').prop('disabled', true);
      //   $('#akhir_transaksi').prop('disabled', true);
      //   $('#awal_terima').prop('disabled', true);
      //   $('#akhir_terima').prop('disabled', true);
      //   $('#awal_kirim').prop('disabled', false);
      //   $('#akhir_kirim').prop('disabled', false);
      //   $('#awal_selesai').prop('disabled', true);
      //   $('#akhir_selesai').prop('disabled', true); 
      // }

      // function enable_selesai() {
      //   $('#awal_transaksi').prop('disabled', true);
      //   $('#akhir_transaksi').prop('disabled', true);
      //   $('#awal_terima').prop('disabled', true);
      //   $('#akhir_terima').prop('disabled', true);
      //   $('#awal_kirim').prop('disabled', true);
      //   $('#akhir_kirim').prop('disabled', true);
      //   $('#awal_selesai').prop('disabled', false);
      //   $('#akhir_selesai').prop('disabled', false)
      // }

      function editTransaksi() {
        $.ajax({
          type: "post",
          url: "json/editTransaksi.php",
          data: $('#form-edit').serialize(),
          success: result => {
            const res = $.parseJSON(result);
            if(res.success == 1) {
              $('#masterModalEdit').modal('hide');
              $('#table_delivery').DataTable().ajax.reload();
            } alert(res.message);
          },
          error: err => {
            console.error(err.statusText);
          }
        })
      }
      
      function getDelivery(transaksi, id) {
        $.ajax({
          type: "post",
          url: "json/getDelivery.php",
          data: {transaksi: transaksi, id: id},
          success: result => {
            const res = $.parseJSON(result);
            if(res.success == 1) {
              $('#no_transaksi').val(res.data.transaksi);
              $('#nama_ekspedisi').val(res.data.ekspedisi);
              $('#nama_driver').val(res.data.namaDriver);
              $('#no_plat').val(res.data.platDriver);
              const status = res.data.status;
              $('#select_status option[value="' + status + '"').prop('selected', true);
              $('#tgl_transaksi').val(res.data.tglTransaksi);
              $('#tanggal_terima').val(res.data.tglTerima);
              // $('#waktu_terima').val(res.data.waktuTerima);
              $('#tanggal_kirim').val(res.data.tglKirim);
              // $('#waktu_kirim').val(res.data.waktuKirim);
              $('#tanggal_selesai').val(res.data.tglSelesai);
              $('#nama_sales').val(res.data.sales);
              $('#id_transaksi').val(res.data.idTransaksi);
              $('#nama_customer').val(res.data.customer);
              const picker = res.data.picker;
              $('#select_picker option:contains("'+picker+'")').prop('selected', true);
              const wilayah = res.data.wilayah;
              const terima = res.data.tglTerima;
              if(picker == '') {
                $('#select_picker option[value=""]').prop('selected', true);
              } 
              if(status == '') {
                $('#ganti_status option[value=""]').prop('selected', true);
                $('#section-dikirim').addClass('display-none');
                $('#section-selesai').addClass('display-none');
              } else if(status == '1') {
                $('#ganti_status option[value="1"]').prop('selected', true);
                $('#tanggal_kirim').val('');
                $('#nama_ekspedisi').val('');
                $('#nama_driver').val('');
                $('#no_plat').val('');
                $('#tanggal_selesai').val('');
                $('#section-dikirim').addClass('display-none');
                $('#section-selesai').addClass('display-none');
              } else if (status == '2') {
                $('#ganti_status option[value="2"]').prop('selected', true);
                $('#tanggal_selesai').val('');
                $('#section-dikirim').removeClass('display-none');
                $('#section-selesai').addClass('display-none');
              } else {
                $('#ganti_status option[value="3"]').prop('selected', true);
                $('#section-dikirim').removeClass('display-none');
                $('#section-selesai').removeClass('display-none');
              }
              if(wilayah != '') {
                $('#wilayah_pengiriman option[value="' + wilayah + '"]').prop('selected', true);
              }
              const pengiriman = res.data.jenisPengiriman;
              if(pengiriman != '') {
                $('#select_pengiriman option[value="' + pengiriman + '"]').prop('selected', true);
              }
            }
          },
          error: err => {
            console.error(err.statusText);
          }
        })
      }

      function getPicker() {
        $.ajax({
          type: "post",
          url: "json/search_picker.php",
          success: result => {
            const res = $.parseJSON(result);
            if (res.success == 1) {
              if($('#select_picker').children().length == 1) {
                for (i = 0; i < res.data.length; ++i) {
                  $('<option>',
                  {
                    html: (res.data[i]).concat(' (' + res.id_data[i] + ')'),
                    value: res.data[i],
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
              if($('#select_driver').children().length == 1) {
                for (i = 0; i < res.data.length; ++i) {
                  $('<option>',
                  {
                    html: (res.data[i]).concat(' (' + res.id_data[i] + ')'), 
                    value: res.data[i],
                  }).appendTo('#select_driver');
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
              if($('#select_plat').children().length == 1) {
                for (i = 0; i < res.data.length; ++i) {
                  $('<option>',
                  {
                    html: res.data[i], 
                    value: res.data[i],
                  }).appendTo('#select_plat');
                }
              }   
            }
          },
          error: err => {
            console.error(err.statusText);
          }
        })
      }

      $('#masterModalEdit').on('shown.bs.modal', function() {
        // if($('#select_status').val() == '1') {
        //   $('#tanggal_kirim').val('');
        //   $('#nama_ekspedisi').val('');
        //   $('#nama_driver').val('');
        //   $('#no_plat').val('');
        //   $('#tanggal_selesai').val('');
        //   $('#section-dikirim').css('display', 'none');
        //   $('#section-selesai').css('display', 'none');
        // } else if($('#select_status').val() == '2'){
        //   $('#tanggal_selesai').val('');
        //   $('#section-dikirim').css('display', 'block');
        //   $('#section-selesai').css('display', 'none');
        // } else if($('#select_status').val() == '3'){
        //   $('#section-dikirim').css('display', 'block');
        //   $('#section-selesai').css('display', 'block');
        // } else {
        //   $('#section-dikirim').css('display', 'none');
        //   $('#section-selesai').css('display', 'none');
        // }
        if($('#select_pengiriman').val() == 'Ambil Sendiri') {
          $('#nama_ekspedisi').val('');
          $('#nama_driver').val('');
          $('#no_plat').val('');
          $('#driver_section').addClass('display-none');
          $('#plat_section').addClass('display-none');
          $('#wilayah_pengiriman option[value=""]').prop('selected', true);
          $('#section_wilayah').addClass('display-none');
          $('#ekspedisi').addClass('display-none');
        } else if($('#select_pengiriman').val() == 'Via Sales') {
          $('#nama_ekspedisi').val('');
          $('#nama_driver').val('');
          $('#no_plat').val('');
          $('#driver_section').addClass('display-none');
          $('#plat_section').addClass('display-none');
          $('#wilayah_pengiriman option[value=""]').prop('selected', true);
          $('#section_wilayah').addClass('display-none');
          $('#ekspedisi').addClass('display-none');
        } else {
          $('#section_wilayah').removeClass('display-none');
          $('#ekspedisi').removeClass('display-none');
          $('#driver_section').removeClass('display-none');
          $('#plat_section').removeClass('display-none');
        }

        if($('#wilayah_pengiriman').val() == 'Dalam Kota') {
          $('#nama_ekspedisi').val('');
          $('#ekspedisi').addClass('display-none');
          $('#driver_section').removeClass('display-none');
          $('#plat_section').removeClass('display-none');
        } else if($('#wilayah_pengiriman').val() == 'Luar Kota') {
          $('#ekspedisi').removeClass('display-none');
          $('#nama_driver').val('');
          $('#no_plat').val('');
          $('#driver_section').addClass('display-none');
          $('#plat_section').addClass('display-none');
        }
      })

      function checkStatus() {
        // console.log($('#ganti_status').val());
        if($('#ganti_status').val() == '1') {
          $('#tanggal_kirim').val('');
          $('#nama_ekspedisi').val('');
          $('#nama_driver').val('');
          $('#no_plat').val('');
          $('#select_pengiriman option[value=""]').prop('selected', true);
          $('#wilayah_pengiriman option[value=""]').prop('selected', true);
          $('#tanggal_selesai').val('');
          $('#section-dikirim').addClass('display-none');
          $('#section-selesai').addClass('display-none');
        } else if($('#ganti_status').val() == '2'){
          if($('#tanggal_terima').val() == '') {
            $('#tanggal_terima').val(today);
          }
          if($('#tanggal_kirim').val() == '') {
            $('#tanggal_kirim').val(today);
          }
          $('#tanggal_selesai').val('');
          $('#section-dikirim').removeClass('display-none');
          $('#section-selesai').addClass('display-none');
        } else if($('#ganti_status').val() == '3') {
          if($('#tanggal_kirim').val() == '') {
            $('#tanggal_kirim').val(today);
          }
          $('#tanggal_selesai').val(today);
          $('#section-dikirim').removeClass('display-none');
          $('#section-selesai').removeClass('display-none');
        }
      }

      function jenisPengiriman() {
        if($('#select_pengiriman').val() == 'Ambil Sendiri') {
          $('#nama_ekspedisi').val('');
          $('#nama_driver').val('');
          $('#no_plat').val('');
          $('#ekspedisi').addClass('display-none');
          $('#driver_section').addClass('display-none');
          $('#plat_section').addClass('display-none');
          $('#wilayah_pengiriman option[value=""]').prop('selected', true);
          $('#section_wilayah').addClass('display-none');
        } else if($('#select_pengiriman').val() == 'Via Sales') {
          $('#nama_ekspedisi').val('');
          $('#nama_driver').val('');
          $('#no_plat').val('');
          $('#ekspedisi').addClass('display-none');
          $('#driver_section').addClass('display-none');
          $('#plat_section').addClass('display-none');
          $('#wilayah_pengiriman option[value=""]').prop('selected', true);
          $('#section_wilayah').addClass('display-none');
        } else {
          $('#section_wilayah').removeClass('display-none');
          $('#ekspedisi').removeClass('display-none');
          $('#driver_section').removeClass('display-none');
          $('#plat_section').removeClass('display-none');
        }
      }

      function tempat_pengiriman() {
        if($('#wilayah_pengiriman').val() == 'Dalam Kota') {
          $('#nama_ekspedisi').val('');
          $('#ekspedisi').addClass('display-none');
          $('#driver_section').removeClass('display-none');
          $('#plat_section').removeClass('display-none');
        } else {
          $('#ekspedisi').removeClass('display-none');
          $('#nama_driver').val('');
          $('#no_plat').val('');
          $('#driver_section').addClass('display-none');
          $('#plat_section').addClass('display-none');
        }
      }
      
      // if(!$('#kirim_cust').is(':checked')) {
      //     $('#select_driver').prop('disabled', true);
      //     $('#select_plat').prop('disabled', true);
      // } 

      // if(!$('#ambil_sendiri').is(':checked')) {
      //     $('#driver_cust').prop('disabled', true);
      //     $('#plat_cust').prop('disabled', true);
      // } 

      // if(!$('#via_sales').is(':checked')) {
      //     $('#select_sales').prop('disabled', true);
      // }

      //  
      // if($('.form-check-input:checked[type="radio"]').checked) {
      //   alert('Button Checked');
      // }

    </script>

  </body>

</html>
