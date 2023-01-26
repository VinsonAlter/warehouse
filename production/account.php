<?php

    session_start();

    require_once '../function.php';

    // cek apakah user sudah login, apabila belum login arahkan user ke laman login

    if(!isset($_SESSION['user_login'])) {

      header("location:../login.php");  

    }

    // $database = query("SELECT * FROM [WMS-System].[dbo].[TB_User] WHERE aktif = 1");

    $server = $_SESSION['cabang_user'];

    $nama = $_SESSION['user_login'];

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

    <!-- Google Font -->
    
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">

    <style>

      /* body {
        overflow:hidden;
      }
       */

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
          <?php require 'sidebar.php'; ?>
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
              <h4 class="page-title">User Account</h4>
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
                  <table id="table_user" class="table table-striped table-bordered table-condensed display compact " style="width:1400px">
                    <thead>
                      <tr>
                        <th style="width:10px">No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Database</th>
                        <th>Segmen</th>
                        <th>Otoritas</th>
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
      <!-- End Page wrapper  -->
      <!-- ============================================================== -->

      <!-- Bootstrap Modals for Adding New User -->
      <div class="modal fade" id="masterModal" tabindex="-1" role="dialog" aria-labelledby="masterModallabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Tambah User</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="masterModallabel">&times;</span>
                  </button>
                </div>
                <form class="form-horizontal" id="form-submit" method="post" action="javascript:initSubmit()" role="form">
                <div class="modal-body">
                  <div class="input-group mb-2">
                    <label class="input-group-text col-md-4 col-6 required" for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" autocomplete="off" required> 
                  </div>
                  <div class="input-group mb-2">
                    <label class="input-group-text col-md-4 col-6 required" for="userName">Username</label>
                    <input type="text" class="form-control" id="userName" name="userName" autocomplete="off" required>  
                  </div>
                  <div class="input-group mb-2">
                    <label class="input-group-text col-md-4 col-6 required" for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" autocomplete="off" required>
                  </div>
                  <div class="input-group mb-2">
                    <label class="input-group-text col-md-4 col-6 required" for="conf_pass">Confirm Password</label>
                    <input type="password" class="form-control" id="conf_pass" name="conf_pass" autocomplete="off" required>
                  </div>
                  <div class="form-check input-group mb-2">
                    <div class = "px-2 col-1">
                      <input class="cp form-check-input" type="checkbox" id="userAktif" name="check" value="1">
                      <label class="cp" for="userAktif">Aktif</label>
                    </div>
                  </div>
                  <p style="margin-left:2px;color:red;"> <b> (*) Database, Segmen dan Otoritas harus dicentang setidaknya satu</b></p>
                  <div class="d-flex">
                    <p class="col-6 ml-half"> <b>Select Database : </b></p>
                    <p class="col-6" style="margin-left:2px"> <b>Select Segmen : </b></p>
                  </div>
                  <div class = "input-group mb-3">   
                    <!-- read the check-label and check-input from database -->
                    <div class = "col col-md-6">
                      <div class="form-check ml-half">
                        <div class="d-flex flex-column">
                          <?php foreach ($database as $row): ?>
                            <label class="cp form-check-label">
                              <input class="cp form-check-input" id="<?=$row['warehouse']?>" type="checkbox"  name="server[]" value="<?=$row['warehouse']?>">
                              <?=$row['warehouse']?>
                            </label>
                          <?php endforeach;?>
                        </div>
                      </div>
                    </div>
                    <div class = "col col-md-6">
                      <div class="ml-half">
                        <div class="d-flex flex-column">
                          <div class="d-flex">
                            <input id="AS" name="segmen[]" class="cp form-check-input" type="checkbox"  
                              value="AS">
                            <label for="AS" class="cp form-check-label ml-half">AS</label>
                          </div>
                          <div class="d-flex">
                            <input id="CO" name="segmen[]" class="cp form-check-input" type="checkbox"  
                              value="CO">
                            <label for="CO" class="cp form-check-label ml-half">CO</label>
                          </div>
                          <div class="d-flex">
                            <input id="SS" name="segmen[]" class="cp form-check-input" type="checkbox"  
                              value="SS">
                            <label for="SS" class="cp form-check-label ml-half">SS</label>
                          </div>
                          <div class="d-flex">
                            <input id="CS" name="segmen[]" class="cp form-check-input" type="checkbox"  
                              value="CS">
                            <label for="CS" class="cp form-check-label ml-half">CS</label>
                          </div>
                          <div class="d-flex">
                            <input id="BP" name="segmen[]" class="cp form-check-input" type="checkbox"  
                              value="BP">
                            <label for="BP" class="cp form-check-label ml-half">BP</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="ml-half input-group mb-2">
                    <b>Select Otoritas:</b>
                    <div class = "col col-md-6">
                      <div class="ml-half">
                        <div class="d-flex flex-column">
                          <div class="d-flex">
                            <input id="Database" name="otoritas[]" class="cp form-check-input" type="checkbox"  
                              value="database">
                            <label for="Database" class="cp form-check-label ml-half">Database</label>
                          </div>
                          <div class="d-flex">
                            <input id="Picker" name="otoritas[]" class="cp form-check-input" type="checkbox"  
                              value="picker">
                            <label for="Picker" class="cp form-check-label ml-half">Picker</label>
                          </div>
                          <div class="d-flex">
                            <input id="Mobil" name="otoritas[]" class="cp form-check-input" type="checkbox"  
                              value="mobil">
                            <label for="Mobil" class="cp form-check-label ml-half">Mobil</label>
                          </div>
                          <div class="d-flex">
                            <input id="Driver" name="otoritas[]" class="cp form-check-input" type="checkbox"  
                              value="driver">
                            <label for="Driver" class="cp form-check-label ml-half">Driver</label>
                          </div>
                          <div class="d-flex">
                            <input id="User" name="otoritas[]" class="cp form-check-input" type="checkbox"  
                              value="user-account">
                            <label for="User" class="cp form-check-label ml-half">User Account</label>
                          </div>
                          <div class="d-flex">
                            <input id="Delivery" name="otoritas[]" class="cp form-check-input" type="checkbox"  
                              value="picking-delivery">
                            <label for="Delivery" class="cp form-check-label ml-half">Picking & Delivery</label>
                          </div>
                          <div class="d-flex">
                            <input id="Status" name="otoritas[]" class="cp form-check-input" type="checkbox"
                              value="status-delivery">
                            <label for="Status" class="cp form-check-label ml-half">Status Delivery</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- <p style="margin-left:2px"><span style="color:red;">(*)</span> <b>Wajib Diisi</b></p> -->
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

      <!-- Bootstrap Modals Edit User Account -->

      <div class="modal fade" id="masterModalEdit" tabindex="-1" role="dialog" aria-labelledby="masterModallabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Edit User</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="masterModallabel">&times;</span>
                  </button>
                </div>
                <form class="form-horizontal" id="form-edit" method="post" action="javascript:initEdit()" role="form">
                <div class="modal-body">
                  <div class="input-group mb-2">
                    <input type="hidden" class="form-control" id="edit_id" name="id">
                  </div>
                  <div class="input-group mb-2">
                    <label class="input-group-text col-6 col-md-4 required" for="edit_name">Name</label>
                    <input type="text" class="form-control" id="edit_name" name="edit_name" autocomplete="off" required> 
                  </div>
                  <div class="input-group mb-2">
                    <label class="input-group-text col-6 col-md-4 required" for="edit_username">Username</label>
                    <input type="text" class="form-control" id="edit_username" name="edit_username" autocomplete="off" required>  
                  </div>
                  <div class="input-group mb-2">
                    <label class="input-group-text col-6 col-md-4" for="edit_password">Password</label>
                    <input type="password" class="form-control" id="edit_password" name="edit_password" autocomplete="off">
                  </div>
                  <div class="input-group mb-2">
                    <label class="input-group-text col-6 col-md-4" for="edit_confirm">Confirm Password</label>
                    <input type="password" class="form-control" id="edit_confirm" name="edit_confirm" autocomplete="off">
                  </div>
                  <div class="form-check input-group mb-2">
                    <div class = "col-1 ml-half">
                      <input class="cp form-check-input" type="checkbox" id="edit_aktif" name="edit_aktif" value="1">
                      <label class="cp" for="edit_aktif">Aktif</label>
                    </div>
                  </div>
                  <p style="margin-left:2px;color:red;"> <b> (*) Database, Segmen dan Otoritas harus dicentang setidaknya satu </b></p>
                  <div class="d-flex">
                    <p class="col-6 ml-half"> <b>Select Database : </b></p>
                    <p class="col-6" style="margin-left:2px"> <b>Select Segmen : </b></p>
                  </div>
                  <div class = "input-group mb-2">
                    <!-- read the check-label and check-input from database -->
                    <div class = "col col-md-6">
                      <div class="form-check ml-half">
                        <div class="d-flex flex-column">
                          <?php foreach ($database as $row): ?>
                            <label class="cp form-check-label">
                              <input class="cp form-check-input" id="<?=$row['warehouse']?>" type="checkbox"  name="server[]" value="<?=$row['warehouse']?>">
                              <?=$row['warehouse']?>
                            </label>
                          <?php endforeach;?>
                        </div>
                      </div>
                    </div>
                    <div class = "col col-md-6">
                      <div class="ml-half">
                        <div class="d-flex flex-column">
                          <div class="d-flex">
                            <input id="edit_AS" name="segmen[]" class="cp form-check-input" type="checkbox"  
                              value="AS">
                            <label name="AS" for="edit_AS" class="cp form-check-label ml-half">AS</label>
                          </div>
                          <div class="d-flex">
                            <input id="edit_CO" name="segmen[]" class="cp form-check-input" type="checkbox"  
                              value="CO">
                            <label name="CO" for="edit_CO" class="cp form-check-label ml-half">CO</label>
                          </div>
                          <div class="d-flex">
                            <input id="edit_SS" name="segmen[]" class="cp form-check-input" type="checkbox"  
                              value="SS">
                            <label name="SS" for="edit_SS" class="cp form-check-label ml-half">SS</label>
                          </div>
                          <div class="d-flex">
                            <input id="edit_CS" name="segmen[]" class="cp form-check-input" type="checkbox"  
                              value="CS">
                            <label for="edit_CS" class="cp form-check-label ml-half">CS</label>
                          </div>
                          <div class="d-flex">
                            <input id="edit_BP" name="segmen[]" class="cp form-check-input" type="checkbox"  
                              value="BP">
                            <label for="edit_BP" class="cp form-check-label ml-half">BP</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="ml-half input-group mb-2">
                    <b>Select Otoritas:</b>
                    <div class = "col col-md-6">
                      <div class="ml-half">
                        <div class="d-flex flex-column">
                          <div class="d-flex">
                            <input id="edit_database" name="otoritas[]" class="cp form-check-input" type="checkbox"  
                              value="database">
                            <label for="edit_database" class="cp form-check-label ml-half">Database</label>
                          </div>
                          <div class="d-flex">
                            <input id="edit_picker" name="otoritas[]" class="cp form-check-input" type="checkbox"  
                              value="picker">
                            <label for="edit_picker" class="cp form-check-label ml-half">Picker</label>
                          </div>
                          <div class="d-flex">
                            <input id="edit_mobil" name="otoritas[]" class="cp form-check-input" type="checkbox"  
                              value="mobil">
                            <label for="edit_mobil" class="cp form-check-label ml-half">Mobil</label>
                          </div>
                          <div class="d-flex">
                            <input id="edit_driver" name="otoritas[]" class="cp form-check-input" type="checkbox"  
                              value="driver">
                            <label for="edit_driver" class="cp form-check-label ml-half">Driver</label>
                          </div>
                          <div class="d-flex">
                            <input id="edit_user" name="otoritas[]" class="cp form-check-input" type="checkbox"  
                              value="user-account">
                            <label for="edit_user" class="cp form-check-label ml-half">User Account</label>
                          </div>
                          <div class="d-flex">
                            <input id="edit_delivery" name="otoritas[]" class="cp form-check-input" type="checkbox"  
                              value="picking-delivery">
                            <label for="edit_delivery" class="cp form-check-label ml-half">Picking & Delivery</label>
                          </div>
                          <div class="d-flex">
                            <input id="edit_status" name="otoritas[]" class="cp form-check-input" type="checkbox"
                              value="status-delivery">
                            <label for="edit_status" class="cp form-check-label ml-half">Status Delivery</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- <p style="margin-left:2px"><span style="color:red;">(*)</span> <b>Wajib Diisi</b></p> -->
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
        $('#masterModal').on('show.bs.modal', function() {
          // prop checked true all modals checkboxes, when modal is shown
          $("#masterModal input[type=checkbox]").each(function(){
            $(this).prop("checked", true);
          });
          $('#masterModal .modal-body input[type=password]').val('');
          $("#SS").prop("checked", false);
          $("#CS").prop("checked", false);
          $("#BP").prop("checked", false);
        });

        $('#masterModalEdit').on('show.bs.modal', function() {
          $('#masterModalEdit .modal-body input[type=password]').val('');
        });

        // clear modals input when modal closed
        $('#masterModal').on('hide.bs.modal', function() {
          $('#masterModal .modal-body input[type=text]').val('');
          $('#masterModal .modal-body input[type=password]').val('');
        });

        // this function check if at least one of the checkbox is checked
        var requiredCheckboxes = $('#masterModal .modal-body :checkbox[required]');
        requiredCheckboxes.change(function(){
          if(requiredCheckboxes.is(':checked')) {
              requiredCheckboxes.removeAttr('required');
          } else {
              requiredCheckboxes.attr('required', 'required');
          }
        });

        var tableUser = $('#table_user').DataTable({
          "processing": true,
          "serverSide": true,
          "deferRender": true,
          "stateSave": true,
          "stateDuration": -1,
          "pageLength": 10,
          "ajax": {
            url: 'json/data_user.php',
          },
          "language": {
            "processing": '<div class="loader"></div>',
          },
          "order": [[2, "asc"]],
          "columnDefs": [
            { orderable: false, targets: [0, 3, 4, 5, 6, 7] },
            { width: '50%', targets: 3},
            { width: '15%', targets: 4},
            { width: '35%', targets: 5},
            { className: 'dt-center', targets: [0, 6, 7]},
            // this part renders font awesome checklist or cross according to active value
            {
              targets: 6,
              render: function(data) {
                if (data == '0') {
                return "<i class='fa fa-times-circle fa-lg text-danger'></i>"
                } else  {
                return "<i class='fa fa-check-circle fa-lg text-success'></i>"
                }
              }  
            },
          ],
        });

        tableUser.on('draw.dt', () => {
          const PageInfo = $('#table_user').DataTable().page.info()
				    tableUser.column(0, { page: 'current' }).nodes().each((cell, i) => {
						cell.innerHTML = i + 1 + PageInfo.start
					})
        })
      });

      // remove required attributes when checkbox is checked
      var requiredEditCheckboxes = $('#masterModalEdit .modal-body :checkbox[required]');
        requiredEditCheckboxes.change(function(){
          if(requiredEditCheckboxes.is(':checked')) {
              requiredEditCheckboxes.removeAttr('required');
          } else {
              requiredEditCheckboxes.attr('required', 'required');
          }
      });

      function initSubmit() {
          $.ajax({
            type: "post",
            url: "json/insertUserAccounts.php",
            data: $('#form-submit').serialize(),
            success: result => {
              const res = $.parseJSON(result);
              if(res.success == 1) {
                // clear modals input after submit data
                $('#masterModal .modal-body input[type=text]').val('');
                $('#masterModal .modal-body input[type=password]').val('');
                // hide modals after submit data
                $('#masterModal').modal('hide');
                // reload datatable when ajax success returns success
                $('#table_user').DataTable().ajax.reload();
                window.location.reload();
              } alert (res.message);
            },
            complete: () => {
              window.location.reload();
            },  
            error: err => {
            console.error(err.statusText);
          }
        })
      }

      function initEdit() {
        $.ajax({
          type: "post",
          url: "json/editUser.php",
          data: $('#form-edit').serialize(),
          success: result => {
            const res = $.parseJSON(result);
            if(res.success == 1) {
            // hide modal after data submission
            $('#masterModalEdit').modal('hide');
            // reload datatable when ajax success returns success
            $('#table_user').DataTable().ajax.reload();
            } alert(res.message);
          },
          complete: () => {
            window.location.reload();
          },
          error: err => {
            console.error(err.statusText);
          }
        })
      }

      function getUser(username) {
        // var checkdata = $("input[name='server[]']").map(function(){return $(this).val();}).get();
        // console.log(checkdata);
        $.ajax({
          type: "post",
          url: "json/getUser.php",
          data: {username: username},
          success: result => {
            const res = $.parseJSON(result);
            $('#edit_id').val(res.data.id);
            $('#edit_name').val(res.data.nama);
            $('#edit_username').val(res.data.username);
            // since val() turns array into strings, just put the value inside test
            const test = res.data.server;
            const segments = res.data.segmen;
            const otoritas = res.data.otoritas;
            $testdata = $("#masterModalEdit input[name='server[]']").val(test);
            $segmendata = $("#masterModalEdit input[name='segmen[]']").val(segments);
            $otoritasdata = $("#masterModalEdit input[name='otoritas[]']").val(otoritas);
            $('#edit_aktif').val(res.data.aktif);
            // prop checked if aktif equals to 1, prop unchecked if aktif equals to 0
            if($('#masterModalEdit #edit_aktif').val() == '1'){
              $('#masterModalEdit #edit_aktif').prop("checked", true);
            } else {
              $('#masterModalEdit #edit_aktif').prop("checked", false);
            } 
          },
          error: err => {
            console.error(err.statusText);
          }
        })
      }
    </script>

  </body>

</html>
