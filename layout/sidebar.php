<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= BASEURL ?>" class="brand-link">
      <!-- <img src="layout/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <span class="brand-text font-weight-light">Inventori</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         
          <li class="nav-item">
            <a href="<?= BASEURL ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Data Barang
              </p>
            </a>
          </li>
          
          
          
          <li class="nav-item">
            <a href="<?= BASEURL .'/pemasukan/index.php' ?>" class="nav-link">
              <i class="nav-icon fas fa-download"></i>
              <p>Riwayat Pemasukan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= BASEURL .'/pengeluaran/index.php' ?>" class="nav-link">
              <i class="nav-icon fas fa-upload"></i>
              <p>Riwayat Pengeluaran</p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
