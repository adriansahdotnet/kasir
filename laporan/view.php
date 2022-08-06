<?php 
session_start();
require '../include/koneksi.php';

if (!isset($_SESSION['username'])) {
    header("location:../logout");
    exit();
}

$username = $_SESSION['username'];
$queryUser = mysqli_query($konek, "SELECT * FROM akun WHERE username = '$username'");
$dataUser = mysqli_fetch_assoc($queryUser);

if ($dataUser['level'] !== "admin") {
  header("location:../logout");
  exit();
}

if (!isset($_GET['tipe']) OR !isset($_GET['data'])) {
  header("location:../laporan");
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Preview - <?= $judul; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Favicon -->
  <link rel="icon" href="<?= $link; ?>/assets/dist/img/logo.png">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/plugins/datatables/dataTables.bootstrap4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <?php require '../include/menu.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Preview</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= $link; ?>">Home</a></li>
              <li class="breadcrumb-item active">Preview</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <?= $_GET['tipe']; ?> [<?= $_GET['data']; ?>]
                    <a class="btn btn-primary btn-sm" target="_blank" style="float: right;margin-left: 10px;" href="cetak.php?tipe=<?= $_GET['tipe']; ?>&data=<?= $_GET['data']; ?>">Cetak</a>
                    <a class="btn btn-default btn-sm" style="float: right;" href="../laporan">Kembali</a>
                  </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php if ($_GET['tipe'] === "Data Barang"): ?>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Jenis Satuan</th>
                    <th>Harga Pokok</th>
                    <th>Harga Jual</th>
                    <th>Jumlah Stok</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  if ($_GET['data'] === "All") {
                    $queryDataBarang = mysqli_query($konek, "SELECT * FROM barang ORDER BY nama_barang ASC");
                  } else {
                    $data = $_GET['data'];
                    $queryDataBarang = mysqli_query($konek, "SELECT * FROM barang WHERE kategori = '$data' ORDER BY nama_barang ASC");
                  }
                  $no = 1;
                  while($rowDataBarang = mysqli_fetch_assoc($queryDataBarang)) :
                  ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= $rowDataBarang['kode_barang']; ?></td>
                    <td><?= $rowDataBarang['nama_barang']; ?></td>
                    <td><?= $rowDataBarang['kategori']; ?></td>
                    <td><?= $rowDataBarang['jenis_satuan']; ?></td>
                    <td><?= number_format($rowDataBarang['harga_pokok'],0,',','.'); ?></td>
                    <td><?= number_format($rowDataBarang['harga_eceran'],0,',','.'); ?></td>
                    <td><?= number_format($rowDataBarang['jumlah_stok'],0,',','.'); ?></td>
                  </tr>
                  <?php $no++; endwhile; ?>
                  </tbody>
                </table>
                <?php endif ?>

                <!-- Pembelian Bulanan -->
                <?php if ($_GET['tipe'] === "Pembelian Bulanan" || $_GET['tipe'] === "Pembelian Semua"): ?>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Kasir</th>
                    <th>ID Pembelian</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Jual</th>
                    <th>Total Harga</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  if ($_GET['data'] === "All") {
                    $queryPembelianBulanan = mysqli_query($konek, "SELECT * FROM pembelian ORDER BY id ASC");
                  } else {
                    $data = $_GET['data'];
                    $queryPembelianBulanan = mysqli_query($konek, "SELECT * FROM pembelian WHERE priode = '$data' ORDER BY id ASC");
                  }
                  $no = 1;
                  while($rowPembelianBulanan = mysqli_fetch_assoc($queryPembelianBulanan)) :
                  ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= cari_kasir($rowPembelianBulanan['id_pembelian']); ?></td>
                    <td><?= $rowPembelianBulanan['id_pembelian']; ?></td>
                    <td><?= $rowPembelianBulanan['nama_barang']; ?></td>
                    <td><?= number_format($rowPembelianBulanan['jumlah'],0,',','.'); ?></td>
                    <td><?= number_format($rowPembelianBulanan['harga_eceran'],0,',','.'); ?></td>
                    <td><?= number_format($rowPembelianBulanan['total'],0,',','.'); ?></td>
                  </tr>
                  <?php $no++; endwhile; ?>
                  </tbody>
                </table>
                <?php endif ?>

                <!-- Pembelian Tahunan -->
                <?php if ($_GET['tipe'] === "Pembelian Tahunan") :?>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Kasir</th>
                    <th>ID Pembelian</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Jual</th>
                    <th>Total Harga</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  if ($_GET['data'] === "All") {
                    $queryPembelianBulanan = mysqli_query($konek, "SELECT * FROM pembelian ORDER BY id ASC");
                  } else {
                    $data = $_GET['data'];
                    $queryPembelianBulanan = mysqli_query($konek, "SELECT * FROM pembelian WHERE priode LIKE '%$data%' ORDER BY id ASC");
                  }
                  $no = 1;
                  while($rowPembelianBulanan = mysqli_fetch_assoc($queryPembelianBulanan)) :
                  ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= cari_kasir($rowPembelianBulanan['id_pembelian']); ?></td>
                    <td><?= $rowPembelianBulanan['id_pembelian']; ?></td>
                    <td><?= $rowPembelianBulanan['nama_barang']; ?></td>
                    <td><?= number_format($rowPembelianBulanan['jumlah'],0,',','.'); ?></td>
                    <td><?= number_format($rowPembelianBulanan['harga_eceran'],0,',','.'); ?></td>
                    <td><?= number_format($rowPembelianBulanan['total'],0,',','.'); ?></td>
                  </tr>
                  <?php $no++; endwhile; ?>
                  </tbody>
                </table>
                <?php endif ?>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php require '../include/footer.php' ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= $link; ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= $link; ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="<?= $link; ?>/assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= $link; ?>/assets/plugins/datatables/dataTables.bootstrap4.js"></script>
<!-- FastClick -->
<script src="<?= $link; ?>/assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= $link; ?>/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= $link; ?>/assets/dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
</body>
</html>
