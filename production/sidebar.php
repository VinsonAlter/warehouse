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
    <?php 
        if(in_array('database', $otoritas)) {
            echo '
                <li class="sidebar-item">
                    <a href="master-database.php" class="sidebar-link">
                        <i class="mdi mdi-server"></i>
                        <span class="hide-menu">Database</span>
                    </a>
                </li>
            ';
        }
     
        if(in_array('picker', $otoritas)) {
            echo '
                <li class="sidebar-item">
                    <a href="master-picker.php" class="sidebar-link">
                        <i class="mdi mdi-human-handsup"></i>
                        <span class="hide-menu">Picker</span>
                    </a>
                </li>
            ';
        }

        if(in_array('mobil', $otoritas)) {
            echo '
                <li class="sidebar-item">
                    <a href="master-mobil.php" class="sidebar-link">
                        <i class="mdi mdi-car"></i>
                        <span class="hide-menu">Mobil</span>
                    </a>
                </li>
            ';
        }

        if(in_array('driver', $otoritas)) {
            echo '
                <li class="sidebar-item">
                    <a href="master-driver.php" class="sidebar-link">
                        <i class="mdi mdi-account"></i>
                        <span class="hide-menu">Driver</span>
                    </a>
                </li>
            ';
        }

        if(in_array('user-account', $otoritas)) {
            echo '
                <li class="sidebar-item">
                    <a href="account.php" class="sidebar-link">
                    <i class="mdi mdi-account-edit"></i>
                    <span class="hide-menu">User Account</span>
                    </a>
                </li>
            ';
        }
    ?>
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
    </ul>
</nav>
<!-- End Sidebar navigation -->