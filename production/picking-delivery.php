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
    $tglTransaksi = date('d-m-Y');
    $tglAkhirTransaksi = date('d-m-Y');
    $tglTerima = date('d-m-Y');
    $tglAkhirTerima = date('d-m-Y');
    // $tglKirim = date('d-m-Y');
    $waktuKirim = date('d-m-Y H:i');
    $tglFilterKirim = date('d-m-Y');
    $tglFilterAkhirKirim = date('d-m-Y');
    $state = '';
    if(isset($_REQUEST['filter_tgl'])) {
      $state = $_REQUEST['enable_date'];
      switch($state) {
        case 'terima_on':
          $status = 'terima_on';
          $_SESSION['StatusFilter'] = $status;
          $_SESSION['FilterTglTerima'] = $_POST['tglTerima'];
          $_SESSION['FilterAkhirTerima'] = $_POST['tglAkhirTerima'];
          $_SESSION['FilterTglTransaksi'] = date('d-m-Y');
          $_SESSION['FilterAkhirTransaksi'] = date('d-m-Y');
          $_SESSION['FilterTglKirim'] = date('d-m-Y');
          $_SESSION['FilterAkhirKirim'] = date('d-m-Y');
          break;
        case 'kirim_on':
          $status = 'kirim_on';
          $_SESSION['StatusFilter'] = $status;
          $_SESSION['FilterTglKirim'] = $_POST['tglKirim'];
          $_SESSION['FilterAkhirKirim'] = $_POST['tglAkhirKirim'];
          $_SESSION['FilterTglTransaksi'] = date('d-m-Y');
          $_SESSION['FilterAkhirTransaksi'] = date('d-m-Y');
          $_SESSION['FilterTglTerima'] = date('d-m-Y');
          $_SESSION['FilterAkhirTerima'] = date('d-m-Y');
          break;
        default:
          $status = 'transaksi_on';
          $_SESSION['StatusFilter'] = $status;
          $_SESSION['FilterTglTransaksi'] = $_POST['tglTransaksi'];
          $_SESSION['FilterAkhirTransaksi'] = $_POST['tglAkhirTransaksi'];
          $_SESSION['FilterTglTerima'] = date('d-m-Y');
          $_SESSION['FilterAkhirTerima'] = date('d-m-Y');
          $_SESSION['FilterTglKirim'] = date('d-m-Y');
          $_SESSION['FilterAkhirKirim'] = date('d-m-Y');
          break;
      }
    }

    if(isset($_SESSION['FilterTglTransaksi'])) $tglTransaksi = $_SESSION['FilterTglTransaksi'];

    if(isset($_SESSION['FilterAkhirTransaksi'])) $tglAkhirTransaksi = $_SESSION['FilterAkhirTransaksi'];

    if(isset($_SESSION['FilterTglTerima'])) $tglTerima = $_SESSION['FilterTglTerima'];

    if(isset($_SESSION['FilterAkhirTerima'])) $tglAkhirTerima = $_SESSION['FilterAkhirTerima'];

    if(isset($_SESSION['FilterTglKirim'])) $tglFilterKirim = $_SESSION['FilterTglKirim'];

    if(isset($_SESSION['FilterAkhirKirim'])) $tglFilterAkhirKirim = $_SESSION['FilterAkhirKirim'];

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
    <!-- Bootstrap Timepicker CSS -->
    <link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css"/>
    <!-- Bootstrap 4 Datetimepicker CSS -->
    <link rel="stylesheet" type="text/css" href="assets/libs/bootstrap4-datetimepicker/bootstrap-datetimepicker.min.css"/>
    <!-- Loading CSS -->
    <link href="css/loading.css" rel="stylesheet"/>
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <style>

      /* body {
        overflow:hidden;
      } */
      
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
                      <div class="ml-15em form-group">
                        <div class="mb-2">
                          <div class="d-sm-inline-block d-md-flex mb-3">
                            <label class="mb-3 mb-md-0 mr-half centered d-md-flex">Filter Tgl Transaksi</label>
                            <input type="radio" class="cp mr-8" id="filter_transaksi" name="enable_date" value="transaksi_on" onclick="enable_transaksi()">
                            <input type="text" class="col-md-2 col-4 mydatepicker"
                              name="tglTransaksi" id="tgl_transaksi" value="<?=$tglTransaksi?>" autocomplete="off">
                            <label class="ml-3 centered d-md-flex" style="margin-right:5px;">s/d</label>
                            <input type="text" class="col-md-2 col-4 mydatepicker"
                              name="tglAkhirTransaksi" id="akhir_transaksi" value="<?=$tglAkhirTransaksi?>" autocomplete="off">
                            <button class="px-2 btn btn-success btn-sm text-white ml-half"
                              type="submit" name="filter_tgl" id="btn_filter">
                              Filter
                            </button>
                          </div>
                          <div class="d-sm-inline-block d-md-flex mb-3">
                            <label class="mb-3 mb-md-0 mr-16em centered d-md-flex">Filter Tgl Terima</label>
                            <input type="radio" class="cp mr-8" id="filter_terima" name="enable_date" value="terima_on" onclick="enable_terima()">
                            <input type="text" class="col-md-2 col-4 mydatepicker"
                              name="tglTerima"id="tgl_terima"  value="<?=$tglTerima?>" autocomplete="off">
                            <label class="ml-3 centered d-md-flex" style="margin-right:5px;">s/d</label>
                            <input type="text" class="col-md-2 col-4 mydatepicker"
                              name="tglAkhirTerima" id="akhir_terima" value="<?=$tglAkhirTerima?>" autocomplete="off">
                            <!-- <button class="px-2 btn btn-success btn-sm text-white ml-half"
                              type="submit" name="filter_tgl_terima" id="btn_terima">
                              Filter
                            </button> -->
                          </div>
                          <div class="d-sm-inline-block d-md-flex">
                            <label class="mb-3 mb-md-0 mr-32 centered d-md-flex">Filter Tgl Kirim</label>
                            <input type="radio" class="cp mr-8" id="filter_kirim" name="enable_date" value="kirim_on" onclick="enable_kirim()">
                            <input type="text" class="col-md-2 col-4 mydatepicker"
                              name="tglKirim"id="tgl_kirim" value="<?=$tglFilterKirim?>" autocomplete="off">
                            <label class="ml-3 centered d-md-flex" style="margin-right:5px;">s/d</label>
                            <input type="text" class="col-md-2 col-4 mydatepicker"
                              name="tglAkhirKirim" id="akhir_kirim" value="<?=$tglFilterAkhirKirim?>" autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                  <div id = "edit_part" style="display:none;">
                    <hr/>
                    <div class="ms-auto text-end d-flex mb-3">
                      <h5 class="self-centered col-2 mr-12 page-title">Select Picker : </h5>
                      <select
                        class="cp select2 form-select shadow-none mr-12"
                          style="width: 50%; height:36px;"
                          id="select_picker" name="picker">
                      </select>
                      <button class="btn btn-cyan mr-12" type="button" id="update_pick" name="update_terima"
                        style="width:180px;height:36px;">Update Picking</button>
                      <button class="btn btn-warning mr-12" data-bs-toggle="modal" data-bs-target="#masterModalKirim" type="button" id="update_kirim" name="update_kirim"
                        style="width:180px;height:36px;">Update Kirim</button>
                      <button class="btn btn-secondary" type="button" id="confirm_selesai" name="confirm_selesai"
                        style="width:180px;height:36px;">Confirm Selesai</button>
                    </div>
                    <hr/>
                  </div>
                </div>
                <div class="table-responsive">
                  <table id="table_picking" class="cp table table-bordered table-condensed display compact">
                    <thead>
                      <tr>
                        <th><input type="checkbox" id="select_all" class="cp"></th>
                        <th>No Transaksi</th>
                        <th>Tanggal Transaksi</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Tanggal Terima</th>
                        <th>Picker</th>
                        <th>Tanggal Kirim</th>
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
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- Bootstrap Modals for Pengiriman -->
                <div class="modal fade" id="masterModalKirim" tabindex="-1" role="dialog" aria-labelledby="masterModallabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Schedule Pengiriman</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true" id="masterModallabel">&times;</span>
                        </button>
                      </div>
                      <form class="form-horizontal" id="form_kirim" method="post" action="javascript:kirimTransaksi()" role="form">
                        <div class="modal-body pt-none pb-none">
                          <div class="card-body pb-none">
                            <div class="d-none form-group row">
                              <label class="col-sm-4 control-label col-form-label required">No Transaksi</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="no_transaksi" name="NomorTransaksi" readonly="readonly">
                              </div>
                            </div>
                            <!-- <div class="form-group row"> 
                              <label class="col-sm-4 control-label col-form-label required">Tgl Kirim</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control mydatepicker" name="tanggal_kirim" id="tanggal_kirim"
                                  value="<?=$tglKirim?>">
                              </div>
                            </div> -->
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label required">Jadwal Kirim</label>
                              <div class="col-sm-6">
                                <div class="input-group date datetimepicker">
                                  <input class="form-control" type="text" value="<?=$waktuKirim?>" name="waktu_kirim">
                                  <div class="input-group-append">
                                    <span class="input-group-text input-group-addon" style="padding:0.6rem 0.75rem;">
                                      <span class="fa fa-calendar"></span>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label required">Waktu Kirim</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control mytimepicker" name="waktu_kirim" id="waktu_kirim"
                                  value="<?=$waktuKirim?>">
                              </div>
                            </div> -->
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label required">Jenis Pengiriman</label>
                              <div class="d-flex col-sm-6">
                                <select
                                  class="cp select2 shadow-none form-select"
                                  style="width: 100%; height: 36px"
                                  id="select_pengiriman" name="select_pengiriman"
                                >
                                  <option value="Kirim Customer">Kirim ke Customer</option>
                                  <option value="Ambil Sendiri">Ambil Sendiri</option>
                                  <option value="Via Sales">Via Sales</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label required">Wilayah</label>
                              <div class="col-sm-6">
                                <select
                                    class="cp select2 shadow-none form-select"
                                    id="wilayah_pengiriman" name="wilayah_pengiriman"
                                  >
                                  <option value="Dalam Kota">Dalam Kota</option>
                                  <option value="Luar Kota">Luar Kota</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label required">Nama Ekspedisi</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="nama_ekspedisi" name="nama_ekspedisi">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label required">Nama Driver</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="nama_driver" name="nama_driver">
                              </div>
                              <div class="col-sm-2 d-flex">
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
                            <div class="form-group row">
                              <label class="col-sm-4 control-label col-form-label required">No. Plat</label>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" id="no_plat" name="no_plat">
                              </div>
                              <div class="col-sm-2 d-flex">
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
                        </div>
                        <div class="modal-footer">
                          <button type="submit" name = "btn_submit" class="btn btn-primary">Kirim</button>
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

    <!-- Datepicker JS -->
    <script src="assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

    <!-- Bootstrap Timepicker JS -->
    <script src="assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    
    <!-- Bootstrap 4 Datetimepicker JS -->
    <script src="assets/libs/bootstrap4-datetimepicker/bootstrap-datetimepicker.js"></script>  

    <script>

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
      
      let checkValues = [];

      var state = '<?php echo $state ?>';

      var date = '<?php echo date('d-m-Y')?>'

      function check() {
        if(checkValues == '') {
          $('#edit_part').css('display', 'none');
        } else {
          $('#edit_part').css('display', 'block');
        }
      }
      
      $('#update_kirim').click((e) => {
        e.preventDefault();
        const checkKirim = checkValues.join(" ; ");
        $('#no_transaksi').val(checkKirim);
        console.log(checkKirim);
      })

      function selectPicker() {
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

      function selectDriver() {
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

      function selectPlat() {
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

      function kirimTransaksi() {
        $.ajax({
          type: 'post',
          url: 'json/updateTransaksiKirim.php',
          data: $('#form_kirim').serialize(),
          success: result => {
            const res = $.parseJSON(result);
            if(res.success == 1){
              $('#table_picking').DataTable().ajax.reload();
              $('#masterModalKirim').modal('hide');
            } alert(res.message);
          },
          error: err => {
            console.error(err.statusText);
          }
        })
      }

      $(document).ready(() => {
        selectPicker();
        selectDriver();
        selectPlat();
        /* hide the loader first */
        $('.loader').hide();

        // datepicker
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

        // clear modals input when modal closed
        $('#masterModalKirim').on('hide.bs.modal', function() {
          $('#masterModalKirim .modal-body input[name="nama_ekspedisi"]').val('');
          $('#masterModalKirim .modal-body input[name="nama_driver"]').val('');
          $('#masterModalKirim .modal-body input[name="no_plat"]').val('');
        });

        $('#masterModalKirim').on('show.bs.modal', function() {
          $('#masterModalKirim .modal-body input[name="tanggal_kirim"]').val(date);
        });

        if(state == '' || state == 'transaksi_on') {
          $('#filter_transaksi').prop('checked', true);
          $('#tgl_transaksi').prop('disabled', false);
          $('#akhir_transaksi').prop('disabled', false);
        } else if(state == 'terima_on') {
          $('#filter_terima').prop('checked', true);
        } else {
          $('#filter_kirim').prop('checked', true);
        }

        if(!$('#filter_transaksi').is(':checked')) {
            $('#tgl_transaksi').prop('disabled', true);
            $('#akhir_transaksi').prop('disabled', true);
          } else {
            $('#tgl_transaksi').prop('disabled', false);
            $('#akhir_transaksi').prop('disabled', false);
        }

        if(!$('#filter_terima').is(':checked')) {
            $('#tgl_terima').prop('disabled', true);
            $('#akhir_terima').prop('disabled', true);
          } else {
            $('#tgl_terima').prop('disabled', false);
            $('#akhir_terima').prop('disabled', false);
        }

        if(!$('#filter_kirim').is(':checked')) {
            $('#tgl_kirim').prop('disabled', true);
            $('#akhir_kirim').prop('disabled', true);
          } else {
            $('#tgl_kirim').prop('disabled', false);
            $('#akhir_kirim').prop('disabled', false);
        }

        // fill datatables 
        var tablePicking = $('#table_picking').DataTable({
          "processing": true,
          "serverSide": true,
          "deferRender": true,
          "stateSave": true,
          "stateDuration": -1,
          "pageLength": 25,
          "scrollY": '300px',
          "scrollCollapse": true,
          "ajax": {
            url: "json/getDataDelivery.php"
          },
          "language": {
            "processing": '<div class="loader"></div>',
          },
          "order": [[1, "asc"]],
          "columnDefs": [
            { orderable: false, targets: [0, 1]},
            { targets: 4,
              render: function(data){
                if(data == 1) {
                  return '<b>Diterima</b>';
                } else if(data == 2) {
                  return '<b>Dikirim</b>';
                } else if(data == 3) {
                  return '<b>Selesai</b>';
                }
                else {
                  return '<b>Belum Diterima</b>';
                }
              }
            },
            { className: 'dt-center', targets: [4]}
          ],
          "rowCallback": function(row, data, index) {
            const cellValue = data[4];
            if(cellValue == 1) {
              $('td:eq(4)', row).addClass("bg-diterima");
            } else if(cellValue == 2) {
              $('td:eq(4)', row).addClass("bg-dikirim");
            } else if(cellValue == 3) {
              $('td:eq(4)', row).addClass("bg-selesai");
            } else {
              $('td:eq(4)', row).addClass("bg-belum-diterima");
            }
          },
          "drawCallback": function( settings ) {
            checkValues = [];
            $("input[type=checkbox]").prop('checked', false);
            $("input[type=checkbox]").closest('tr').removeClass('highlight');
            // work around fixedColumns highlight
            $("input[type=checkbox]").closest('tr .dtfc-fixed-left').removeClass('highlight');
            $("input[type=checkbox]").closest('tr .dtfc-fixed-left').nextUntil('tr .dtfc-fixed-left:nth-child(5)').removeClass('highlight');
          } 
        });

        $('#update_pick').click((e) => {
          e.preventDefault();
          // let checkValues = []; 
          // $('#checkbox_val:checked').map(function(){
          // console.log($(this).val());
          // return $(this).val();
          // checkValues.push($(this).val());
          // $(this).prop('checked', false);
          // })
          const picker = $('#select_picker').val();
          // alert(Picker);
          // alert(checkValues);
          const CheckValues = checkValues.join(" ; ");
          $.ajax({
            type: "post",
            url: 'json/insertTransaksiTerima.php',
            data: {batch : CheckValues, picker: picker},
              success: result => {
              checkValues = [];
              const res = $.parseJSON(result);
              if(res.success == 1) {
                e.preventDefault();
                $('#table_picking').DataTable().ajax.reload();
                // window.location.reload();
                // alert(res.message);
                // $('#checkbox_val').prop('checked', false);
              } alert(res.message);
            } ,
            error: err => {
              console.error(err.statusText);
            }
          })
        })

        $('#confirm_selesai').click((e) => {
          e.preventDefault();
          const CheckValues = checkValues.join(" ; ");
          $.ajax({
            type: "post",
            url: 'json/confirmSelesai.php',
            data: {batch: CheckValues},
            success: result => {
              checkValues = [];
              const res = $.parseJSON(result);
              if(res.success == 1) {
                e.preventDefault();
                $('#table_picking').DataTable().ajax.reload();
              } alert(res.message);
            },
            error: err => {
              console.error(err.statusText);
            }
          })
        })
        
        tablePicking.on('draw.dt', () => {
          $('tr').find("input[type='checkbox']").on('click', function() {
            if ($(this).prop('checked') === true) {
              $(this).closest('tr').addClass('highlight');
              // work around fixedColumns highlight
              $(this).closest('tr .dtfc-fixed-left').addClass('highlight');
              $(this).closest('tr .dtfc-fixed-left').nextUntil('tr .dtfc-fixed-left:nth-child(5)').addClass('highlight');
              checkValues.push($(this).val());
              check();
              console.log(checkValues);
            } else {
              $(this).closest('tr').removeClass('highlight');
              // work around fixedColumns highlight
              $(this).closest('tr .dtfc-fixed-left').removeClass('highlight');
              $(this).closest('tr .dtfc-fixed-left').nextUntil('tr .dtfc-fixed-left:nth-child(5)').removeClass('highlight');	  
              checkValues.pop($(this).val());
              check();
              console.log(checkValues);
            }
          });

          /* initiate select all checkboxes highlight */ 

				  $('tr').find('#select_all').on('click', function() {
					  $("input[type='checkbox']").prop('checked', $(this).prop('checked'));
					  if ($(this).prop('checked') === true) {
						  $("input[type='checkbox']").closest('tr').addClass('highlight');
              // work around fixedColumns highlight
              $("input[type='checkbox']").closest('tr .dtfc-fixed-left').addClass('highlight');
              $("input[type='checkbox']").closest('tr .dtfc-fixed-left').nextUntil('tr .dtfc-fixed-left:nth-child(5)').addClass('highlight');
              $($('td #checkbox_val').prop('checked', true)).map(function(){
                checkValues.push($(this).val());
                // checkValues.shift($(this).val());
              })
              checkValues.shift($(this).val());
              check();
              console.log(checkValues);
            } else {
              $("input[type='checkbox']").closest('tr').removeClass('highlight');
              // work around fixedColumns highlight
              $("input[type='checkbox']").closest('tr .dtfc-fixed-left').removeClass('highlight');
              $("input[type='checkbox']").closest('tr .dtfc-fixed-left').nextUntil('tr .dtfc-fixed-left:nth-child(5)').removeClass('highlight');
              $($('td #checkbox_val').prop('checked', false)).map(function(){
                checkValues = [];
              })
              check();
              console.log(checkValues);
            }
            // if ($(this).is( ":checked" )) {
            //     tablePicking.rows(  ).select();        
            // } else {
            //     tablePicking.rows(  ).deselect(); 
            // }
				  });

          
        })

        // tablePicking.on('draw.dt', () => {
        //   const PageInfo = $('#table_picking').DataTable().page.info();
			  //   tablePicking.column(0, { page: 'current' }).nodes().each((cell, i) => {
				//     cell.innerHTML = i + 1 + PageInfo.start
			  //   })
        // }) 
      })

      function enable_transaksi() {
        $('#tgl_transaksi').prop('disabled', false);
        $('#akhir_transaksi').prop('disabled', false);
        $('#tgl_terima').prop('disabled', true);
        $('#akhir_terima').prop('disabled', true);
        $('#tgl_kirim').prop('disabled', true);
        $('#akhir_kirim').prop('disabled', true);     
      }

      function enable_terima() {
        $('#tgl_transaksi').prop('disabled', true);
        $('#akhir_transaksi').prop('disabled', true);
        $('#tgl_terima').prop('disabled', false);
        $('#akhir_terima').prop('disabled', false);
        $('#tgl_kirim').prop('disabled', true);
        $('#akhir_kirim').prop('disabled', true);
      }

      function enable_kirim() {
        $('#tgl_transaksi').prop('disabled', true);
        $('#akhir_transaksi').prop('disabled', true);
        $('#tgl_terima').prop('disabled', true);
        $('#akhir_terima').prop('disabled', true);
        $('#tgl_kirim').prop('disabled', false);
        $('#akhir_kirim').prop('disabled', false);
      }

    </script>
  </body>
</html>
