<?php
    session_start();
    // require_once '../koneksi.php';
    require_once '../function.php';
    date_default_timezone_set('Asia/Jakarta');
    // cek apakah user sudah login, apabila belum login arahkan user ke laman login
    if(!isset($_SESSION['user_login'])) {
      header("location:../login.php");  
    }
    $nama = $_SESSION['user_login'];
    $awalTransaksi = date('d-m-Y');
    $akhirTransaksi = date('d-m-Y');
    $awalTerima = date('d-m-Y');
    $akhirTerima = date('d-m-Y');
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
    <link href="css/datatables.css" rel="stylesheet"/>
    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"/>
    <!-- Loading CSS -->
    <link href="css/loading.css" rel="stylesheet"/>
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <style>

      body {
        overflow:hidden;
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
      <?php require_once 'header-navbar.php';?>
      <aside class="left-sidebar" data-sidebarbg="skin5">
        <div class="scroll-sidebar">
          <?php require_once 'sidebar.php'; ?>
          
        </div>
      </aside>
      <div class="page-wrapper">
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Picking & Delivery</h4>
              <div class="ms-auto text-end">
                <button class="btn btn-cyan" type="button" data-bs-toggle="modal" data-bs-target="#masterModal">Baru</button>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <form method="post" action="" role="form">
                    <div class="col-md-8">
                      <div class="form-group">
                        <div class="mb-2">
                          <div class="d-sm-inline-block d-md-flex mb-3">
                            <label class="mb-3 mb-md-0 mr-half centered d-md-flex">Filter Tgl Transaksi</label>
                            <input type="radio" class="cp mr-8" id="filter_transaksi" name="enable_date" onclick="enable_transaksi()">
                            <input type="text" class="mr-3 col-md-2 col-4 mydatepicker"
                              name="awalStatus" id="awal_transaksi" value="<?=$awalTransaksi?>" autocomplete="off">
                            <label class="centered d-md-flex">s/d.</label>
                            <input type="text" class="ml-3 col-md-2 col-4 mydatepicker"
                              name="akhirStatus" id="akhir_transaksi" value="<?=$akhirTransaksi?>" autocomplete="off">
                          </div>
                          <div class="d-sm-inline-block d-md-flex">
                            <label class="mb-3 mb-md-0 mr-half centered d-md-flex">Filter Tgl Terima</label>
                            <input type="radio" class="cp mr-8" id="filter_terima" name="enable_date" onclick="enable_terima()">
                            <input type="text" class="mr-3 col-md-2 col-4 mydatepicker"
                              name="awalStatus"id="awal_terima"  value="<?=$awalTerima?>" autocomplete="off">
                            <label class="centered d-md-flex">s/d.</label>
                            <input type="text" class="ml-3 col-md-2 col-4 mydatepicker"
                              name="akhirStatus" id="akhir_terima" value="<?=$akhirTerima?>" autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="table-responsive">
                  <table id="table_picker" class="table table-bordered table-condensed display compact">
                    <thead>
                      <tr>
                        <th></th>
                        <th>No Transaksi</th>
                        <th>Tgl Transaksi</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Tanggal Terima</th>
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
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
    
      </div>
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
      $(document).ready(() => {
        /*datepicker*/
        $(".mydatepicker").datepicker({
          format: 'dd-mm-yyyy',
          /* disable sunday in datepicker */
          daysOfWeekDisabled: "0",
          autoclose: true,
          todayHighlight: true
        });

        $('#filter_transaksi').prop('checked', true);

        if(!$('#filter_transaksi').is(':checked')) {
          $('#awal_transaksi').prop('disabled', true);
          $('#akhir_transaksi').prop('disabled', true);
        } else {
          $('#awal_transaksi').prop('disabled', false);
          $('#akhir_transaksi').prop('disabled', false);
        }

        if(!$('#filter_terima').is(':checked')) {
          $('#awal_terima').prop('disabled', true);
          $('#akhir_terima').prop('disabled', true);
        } else {
          $('#awal_terima').prop('disabled', false);
          $('#akhir_terima').prop('disabled', false);
        }
      })

      function enable_transaksi() {
        $('#awal_transaksi').prop('disabled', false);
        $('#akhir_transaksi').prop('disabled', false);
        $('#awal_terima').prop('disabled', true);
        $('#akhir_terima').prop('disabled', true);
      }

      function enable_terima() {
        $('#awal_terima').prop('disabled', false);
        $('#akhir_terima').prop('disabled', false);
        $('#awal_transaksi').prop('disabled', true);
        $('#akhir_transaksi').prop('disabled', true);
      }

    </script>
  </body>
</html>
