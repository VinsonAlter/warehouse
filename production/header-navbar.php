<?php
    require_once '../function.php';
    if(!isset($_SESSION['user_login'])) {
        header("location:../login.php");
    }
    $nama = $_SESSION['user_login'];
?>  
    
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
                  <!-- <a class="dropdown-item" href="javascript:void(0)">
                    <i class="mdi mdi-account me-1 ms-1"></i> My Profile
                  </a> -->
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="../logout.php">
                    <i class="fa fa-power-off me-1 ms-1"></i> Logout
                  </a>
                  <!-- <div class="dropdown-divider"></div> -->
                  <!-- <div class="ps-4 p-10">
                    <a
                      href="javascript:void(0)"
                      class="btn btn-sm btn-success btn-rounded text-white">
                      View Profile                    
                    </a>
                  </div> -->
                </ul>
              </li>
              <!-- ============================================================== -->
              <!-- User profile and search -->
              <!-- ============================================================== -->
            </ul>
          </div>
        </nav>
      </header>