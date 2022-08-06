<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#logout">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= $link; ?>" class="brand-link">
      <img src="<?= $link; ?>/assets/dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><?= $judul; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= $link; ?>/assets/dist/img/foto.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $_SESSION['username']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?= $link; ?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= $link; ?>/pengaturan-aplikasi" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Pengaturan Aplikasi
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= $link; ?>/data-invoice" class="nav-link">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>
                Data Invoice
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= $link; ?>/kelola-barang" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Kelola Barang
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= $link; ?>/pembelian" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Pembelian
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= $link; ?>/laporan" class="nav-link">
              <i class="nav-icon fas fa-server"></i>
              <p>
                Laporan
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-chart-bar"></i>
              <p>
                Grafik Pembelian
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= $link; ?>/grafik-pembelian/per-tanggal.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Per Tanggal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= $link; ?>/grafik-pembelian/per-bulan.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Per Bulan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= $link; ?>/grafik-pembelian/per-tahun.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Per Tahun</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>