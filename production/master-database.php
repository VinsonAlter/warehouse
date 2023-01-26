<?php

    session_start();
    
    require_once '../function.php';

    // cek apakah user sudah login, apabila belum login arahkan user ke laman login

    if(!isset($_SESSION['user_login'])) {

      header("location:../login.php");  

    }

    $nama = $_SESSION['user_login'];

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
      <!-- ============================================================== -->
      <!-- Topbar header - style you can find in pages.scss -->
      <!-- ============================================================== -->

      <?php require_once 'header-navbar.php'?>

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
          <?php require_once 'sidebar.php'; ?>
          
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
              <h4 class="page-title">Database</h4>
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
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="table_database" class="table table-striped table-bordered table-condensed display compact " style="width:85%;">
                    <thead>
                      <tr>
                        <th style="width:10px">No</th>
                        <th>Server Warehouse</th>
                        <th>Aktif</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
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
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <!-- <footer class="footer text-center">
          All Rights Reserved by Matrix-admin. Designed and Developed by
          <a href="https://www.wrappixel.com">WrapPixel</a>.
        </footer> -->
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
      </div>
      <!-- ============================================================== -->
      <!-- End Page wrapper  -->
      <!-- ============================================================== -->

      <!-- Bootstrap Modals for Adding New Driver -->

      <div class="modal fade" id="masterModal" tabindex="-1" role="dialog" aria-labelledby="masterModallabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Tambah Database</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="masterModallabel">&times;</span>
                  </button>
                </div>
                <form class="form-horizontal" id="form-submit" method="post" action="javascript:initSubmit()" role="form">
                <div class="modal-body">   
                  <div class="input-group mb-1">
                    <label class="input-group-text col-6 col-md-5 required" for="namaDatabase">Database Server</label>
                    <input type="text" class="form-control" id="namaDatabase" name="database" autocomplete="off" required>
                  </div>
                  <div class="form-check input-group">
                    <div class = "offset-11 col-1">
                      <input class="cp form-check-input" type="checkbox" id="databaseAktif" name="check" value="1">
                      <label class="cp" for="databaseAktif">Aktif</label>
                    </div>
                  </div>
                  <p style="margin-left:8px"><span style="color:red;">(*)</span> <b>Wajib Diisi</b></p>
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

      <!-- Bootstrap Modals Edit Driver -->

      <div class="modal fade" id="masterModalEdit" tabindex="-1" role="dialog" aria-labelledby="masterModalEditlabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Edit Server</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="masterModalEditlabel">&times;</span>
                  </button>
                </div>
                <form class="form-horizontal" id="form-edit" method="post" action="javascript:initEdit()" role="form">
                <div class="modal-body">
                  <div>
                    <input type="hidden" class="form-control" id="id_server" name="id">
                  </div>
                  <div class="input-group mb-3">
                    <label class="input-group-text col-6 col-md-5" for="editServer">Database Server</label>
                    <input type="text" class="form-control" id="editServer" name="edit_server" autocomplete="off">
                  </div>   
                  <div class="form-check input-group">
                    <div class = "offset-11 col-1">
                      <input class="cp form-check-input" type="checkbox" id="aktifServer" name="edit_aktif">
                      <label class="cp" for="aktifServer">Aktif</label>
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

    <script>

      $(document).ready(() => {

        // automatically checked active, when modal is shown
        $("#masterModal input[type=checkbox]").each(function(){
            $(this).prop("checked", true);
        });

        // clear modals input when modal closed
        $('#masterModal').on('hide.bs.modal', function() {
          $('#masterModal .modal-body input[type=text]').val('');
        });

        var tableDatabase = $('#table_database').DataTable({
          "processing": true,
          "serverSide": true,
          "deferRender": true,
          "stateSave": true,
          "stateDuration": -1,
          "pageLength": 10,
          "ajax": {
            url: 'json/data_server.php'
          },
          "language": {
            "processing": '<div class="loader"></div>',
          },
          "order": [[1, "asc"]],
          "columnDefs": [
            { orderable: false, targets: [0, 2, 3] },
            { width: '5%', targets: 0},
            { width: '10%', targets: [2, 3]},
            { className: 'dt-center', targets: [0, 2, 3]},
            {
              targets: 2,
              render: function(data) {
                if (data == 1)
                return "<i class='fa fa-check-circle fa-lg text-success'></i>"
                else 
                return "<i class='fa fa-times-circle fa-lg text-danger'></i>"
              }  
            },
          ],
        });

        tableDatabase.on('draw.dt', () => {
          const PageInfo = $('#table_database').DataTable().page.info()
            tableDatabase.column(0, { page: 'current' }).nodes().each((cell, i) => {
            cell.innerHTML = i + 1 + PageInfo.start
          })
        })

      });

      function getServer(warehouse) {
        $.ajax({
          type: "post",
          url: "json/getServer.php",
          data: {warehouse: warehouse},
          success: result => {
            const res = $.parseJSON(result);
            $('#id_server').val(res.data.id);
            $('#editServer').val(res.data.warehouse);
            $('#aktifServer').val(res.data.aktif);
            // prop checked if aktif equals to 1, prop unchecked if aktif equals to 0
            if($('#masterModalEdit #aktifServer').val() == 1){
              $('#masterModalEdit #aktifServer').prop("checked", true);
            } else {
              $('#masterModalEdit #aktifServer').prop("checked", false);
            }
          },
          error: err => {
            console.error(err.statusText);
          }
        })
      }

      function initSubmit() {
          $.ajax({
            type: "post",
            url: "json/insertMasterDatabase.php",
            data: $('#form-submit').serialize(),
            success: result => {
              const res = $.parseJSON(result);
              if(res.success == 1) {
                 // clear modals input after submit data
                 $('#masterModal .modal-body input[type=text]').val('');
                 // hide modals after submit data
                 $('#masterModal').modal('hide');
                 // reload datatable when ajax success returns success
                 $('#table_database').DataTable().ajax.reload();
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
            url: "json/editServer.php",
            data: $('#form-edit').serialize(),
            success: result => {
              const res = $.parseJSON(result);
              if(res.success == 1) {
                // hide modal after data submission
                $('#masterModalEdit').modal('hide');
                // reload datatable when ajax success returns success
                $('#table_database').DataTable().ajax.reload();
              } alert(res.message);
            },
            error: err => {
              console.error(err.statusText);
            }
          })
        }

    </script>

  </body>

</html>
