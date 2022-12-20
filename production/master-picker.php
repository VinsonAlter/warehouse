<?php

    session_start();

    // require_once '../koneksi.php';

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

    <link href="dist/css/style.min.css" rel="stylesheet" />

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"> -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link  href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet"/>

    <!-- Loading CSS -->

    <link href="dist/css/loading.css" rel="stylesheet"/>

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
                    src="assets/images/users/1.jpg"
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
                  <img src="assets/images/users/1.jpg" alt="..." class="rounded-circle nav_img" >
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
                    <a href="master-account.php" class="sidebar-link">
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
                    <a href="icon-fontawesome.html" class="sidebar-link">
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
              <h4 class="page-title">Picker</h4>
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
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="table_picker" class="table table-striped table-bordered table-condensed display compact " style="width:95%">
                      <thead>
                        <tr>
                          <th style="width:10px">No</th>
                          <th>Picker ID</th>
                          <th>Nama Picker</th>
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

      <!-- Bootstrap Modals for Adding New Picker -->

      <div class="modal fade" id="masterModal" tabindex="-1" role="dialog" aria-labelledby="masterModallabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Tambah Picker</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="masterModallabel">&times;</span>
                  </button>
                </div>
                <form class="form-horizontal" id="form-submit" method="post" action="javascript:initSubmit()" role="form">
                <div class="modal-body">
                  <div class="input-group mb-3">
                    <label class="input-group-text col-3 required" for="kodePicker">Kode Picker</label>
                    <input type="text" class="form-control" id="kodePicker" name="kode" autocomplete="off" required>
                  </div>   
                  <div class="input-group mb-1">
                    <label class="input-group-text col-3 required" for="namaPicker">Nama Picker</label>
                    <input type="text" class="form-control" id="namaPicker" name="nama" autocomplete="off" required>
                  </div>
                  <div class="form-check input-group">
                    <div class="col-11">
                    </div>
                    <div class = "col-1">
                      <input class="form-check-input" type="checkbox" id="pickerAktif" name="check" value="1">
                      <label for="pickerAktif">Aktif</label>
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

      <!-- Bootstrap Modals Edit Picker -->

      <div class="modal fade" id="masterModalEdit" tabindex="-1" role="dialog" aria-labelledby="masterModalEditlabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Edit Picker</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="masterModalEditlabel">&times;</span>
                  </button>
                </div>
                <form class="form-horizontal" id="form-edit" method="post" action="javascript:initEdit()" role="form">
                <div class="modal-body">
                  <div class="input-group mb-3">
                    <label class="input-group-text col-3" for="editKode">Kode Picker</label>
                    <input type="text" class="form-control" id="editKode" name="edit_kode" readonly="readonly">
                  </div>   
                  <div class="input-group mb-1">
                    <label class="input-group-text col-3" for="editNama">Nama Picker</label>
                    <input type="text" class="form-control" id="editNama" name="edit_nama" autocomplete="off">
                  </div>
                  <div class="form-check input-group">
                    <div class="col-11">
                    </div>
                    <div class = "col-1">
                      <input class="form-check-input" type="checkbox" id="aktifPicker" name="edit_aktif">
                      <label for="aktifPicker">Aktif</label>
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
    <script src="dist/js/waves.js"></script>
    
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>

    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>

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

        var tablePicker = $('#table_picker').DataTable({
          "processing": true,
          "serverSide": true,
          "deferRender": true,
          "stateSave": true,
          "stateDuration": -1,
          "pageLength": 10,
          "ajax": {
            url: 'json/data_picker.php'
          },
          "language": {
            "processing": '<div class="loader"></div>',
          },
          "order": [[2, "asc"]],
          "columnDefs": [
            { orderable: false, targets: [0, 3, 4] },
            { width: '15%', targets: 1 },
            { width: '5%', targets: 4},
            { width: '10%', targets: 3},
            { className: 'dt-center', targets: [0, 3, 4]},
            {
              targets: 3,
              render: function(data) {
                if (data == 1)
                return "<i class='fa fa-check-circle fa-lg text-success'></i>"
                else 
                return "<i class='fa fa-times-circle fa-lg text-danger'></i>"
              }  
            },
          ],
        });

        tablePicker.on('draw.dt', () => {
          const PageInfo = $('#table_picker').DataTable().page.info()
				    tablePicker.column(0, { page: 'current' }).nodes().each((cell, i) => {
						cell.innerHTML = i + 1 + PageInfo.start
					})
        })
      });

      function getPicker(nama) {
        $.ajax({
          type: "post",
          url: "json/getPicker.php",
          data: {nama: nama},
          success: result => {
            const res = $.parseJSON(result);
            $('#editKode').val(res.data.kode);
            $('#editNama').val(res.data.nama);
            $('#aktifPicker').val(res.data.aktif);
            // prop checked if aktif equals to 1, prop unchecked if aktif equals to 0
            if($('#masterModalEdit #aktifPicker').val() == 1){
              $('#masterModalEdit #aktifPicker').prop("checked", true);
            } else {
              $('#masterModalEdit #aktifPicker').prop("checked", false);
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
            url: "json/insertMasterPicker.php",
            data: $('#form-submit').serialize(),
            success: result => {
              const res = $.parseJSON(result);
              if(res.success == 1) {
                 // clear modals input after submit data
                 $('#masterModal .modal-body input[type=text]').val('');
                 // hide modals after submit data
                 $('#masterModal').modal('hide');
                 // reload datatable when ajax success returns success
                 $('#table_picker').DataTable().ajax.reload();
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
            url: "json/editPicker.php",
            data: $('#form-edit').serialize(),
            success: result => {
              const res = $.parseJSON(result);
              if(res.success == 1) {
                // hide modal after data submission
                $('#masterModalEdit').modal('hide');
                // reload datatable when ajax success returns success
                $('#table_picker').DataTable().ajax.reload();
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
