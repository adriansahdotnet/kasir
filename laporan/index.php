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

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Laporan - <?= $judul; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/plugins/sweetalert2/sweetalert2.min.css">
  <!-- Favicon -->
  <link rel="icon" href="<?= $link; ?>/assets/dist/img/logo.png">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/plugins/select2/css/select2.min.css">
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
            <h1>Laporan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= $link; ?>">Home</a></li>
              <li class="breadcrumb-item active">Laporan</li>
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
              <div class="card-body p-0">
                <table class="table">
                <tr>
                  <th style="width: 10px">No</th>
                  <th>Laporan</th>
                  <th style="width: 10px;text-align: center;">Aksi</th>
                </tr>
                <tr>
                  <td style="text-align: center;">1</td>
                  <td>Data Barang</td>
                  <td>
                    <span class="badge bg-primary" onclick="modal_print('data-barang');" style="cursor: pointer;"><i class="fa fa-print p-1"></i> Print</span>
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center;">2</td>
                  <td>Pembelian Semua</td>
                  <td>
                    <a href="view.php?tipe=Pembelian Semua&data=All" class="badge bg-primary"><i class="fa fa-print p-1"></i> Print</a>
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center;">3</td>
                  <td>Pembelian Bulanan</td>
                  <td>
                    <span class="badge bg-primary" onclick="modal_print('pembelian-bulanan');" style="cursor: pointer;"><i class="fa fa-print p-1"></i> Print</span>
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center;">4</td>
                  <td>Pembelian Tahunan</td>
                  <td>
                    <span class="badge bg-primary" onclick="modal_print('pembelian-tahunan');" style="cursor: pointer;"><i class="fa fa-print p-1"></i> Print</span>
                  </td>
                </tr>
              </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
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

<div class="modal fade" id="data-barang">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Data Barang</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="view.php" method="GET">
        <div class="modal-body">
          <input type="hidden" value="Data Barang" name="tipe">
          <select class="form-control select2" style="width: 100%;" name="data">
            <option value="All">Semua</option>
            <?php 
            $queryDataBarangPrint = mysqli_query($konek, "SELECT DISTINCT kategori FROM barang ORDER BY kategori ASC");
            while($fetchDataBarangPrint = mysqli_fetch_assoc($queryDataBarangPrint)) : 
            ?>
            <option value="<?= $fetchDataBarangPrint['kategori']; ?>"><?= $fetchDataBarangPrint['kategori']; ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Preview</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="pembelian-bulanan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pembelian Bulanan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="view.php" method="GET">
        <div class="modal-body">
          <input type="hidden" value="Pembelian Bulanan" name="tipe">
          <select class="form-control select2" style="width: 100%;" name="data">
            <option value="All">Semua</option>
            <?php 
            $queryPembelianBulanan = mysqli_query($konek, "SELECT DISTINCT priode FROM pembelian ORDER BY id ASC");
            while($fetchPembelianBulanan = mysqli_fetch_assoc($queryPembelianBulanan)) : 

            $pisahPriode = explode(' ', $fetchPembelianBulanan['priode']);

            if(preg_match("/Jan/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Jan', 'Januari', $pisahPriode[0]);
            } else if(preg_match("/Feb/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Feb', 'Februari', $pisahPriode[0]);
            } else if(preg_match("/Mar/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Mar', 'Maret', $pisahPriode[0]);
            } else if(preg_match("/Apr/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Apr', 'April', $pisahPriode[0]);
            } else if(preg_match("/May/i", $pisahPriode[0])) {
              $bulanShow = str_replace('May', 'May', $pisahPriode[0]);
            } else if(preg_match("/Jun/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Jun', 'Juni', $pisahPriode[0]);
            } else if(preg_match("/Jul/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Jul', 'Juli', $pisahPriode[0]);
            } else if(preg_match("/Aug/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Aug', 'Agustus', $pisahPriode[0]);
            } else if(preg_match("/Sep/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Sep', 'September', $pisahPriode[0]);
            } else if(preg_match("/Oct/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Oct', 'Oktober', $pisahPriode[0]);
            } else if(preg_match("/Nov/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Nov', 'November', $pisahPriode[0]);
            } else if(preg_match("/Dec/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Dec', 'Desember', $pisahPriode[0]);
            }

            ?>
            <option value="<?= $fetchPembelianBulanan['priode']; ?>"><?= $bulanShow; ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Preview</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="pembelian-tahunan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pembelian Tahunan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="view.php" method="GET">
        <div class="modal-body">
          <input type="hidden" value="Pembelian Tahunan" name="tipe">
          <select class="form-control select2" style="width: 100%;" name="data">
            <option value="All">Semua</option>
            <?php 
            $queryPembelianTahunan = mysqli_query($konek, "SELECT DISTINCT priode FROM pembelian ORDER BY id ASC");
            while($fetchPembelianTahunan = mysqli_fetch_assoc($queryPembelianTahunan)) : 

            $pisahPriodeTahun = explode(' ', $fetchPembelianTahunan['priode']);

            ?>
            <option value="<?= $pisahPriodeTahun[1]; ?>"><?= $pisahPriodeTahun[1]; ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Preview</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- jQuery -->
<script src="<?= $link; ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= $link; ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="<?= $link; ?>/assets/plugins/select2/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="<?= $link; ?>/assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= $link; ?>/assets/plugins/datatables/dataTables.bootstrap4.js"></script>
<!-- FastClick -->
<!-- Select2 -->
<script src="<?= $link; ?>/assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?= $link; ?>/assets/plugins/fastclick/fastclick.js"></script>
<!-- SweetAlert2 -->
<script src="<?= $link; ?>/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= $link; ?>/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= $link; ?>/assets/dist/js/demo.js"></script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  });
  function modal_print(idna) {
    $("#"+idna).modal('show');
  }
</script>
</body>
</html>
